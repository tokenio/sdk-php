<?php

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Tokenio\Config\TokenCluster;
use Tokenio\Config\TokenEnvironment;
use Tokenio\Config\TokenIoBuilder;
use Tokenio\Http\Request\TokenRequest;
use Tokenio\Http\Request\TokenRequestOptions;
use Tokenio\Http\Request\TransferTokenBuilder;
use Tokenio\Security\UnsecuredFileSystemKeyStore;

class TokenSample
{
    const DEVELOPER_KEY = '4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI';

    /**
     * @var UnsecuredFileSystemKeyStore
     */
    private $keyStore;

    private $tokenIO;
    private $member;

    public function __construct()
    {
        $this->keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/../keys/');

        $this->tokenIO = $this->initializeSDK();
        $this->member = $this->initializeMember();
    }

    private function initializeSDK()
    {
        $builder = new TokenIoBuilder();
        $builder->connectTo(TokenCluster::get(TokenEnvironment::SANDBOX));
        $builder->developerKey(self::DEVELOPER_KEY);
        $builder->withKeyStore($this->keyStore);
        return $builder->build();
    }

    private function initializeMember()
    {
        $memberId = $this->keyStore->getFirstMemberId();
        if (!empty($memberId)) {
            return $this->loadMember($memberId);
        } else {
            return $this->createMember();
        }
    }

    private function loadMember($memberId)
    {
        return $this->tokenIO->getMember($memberId);
    }

    private function createMember()
    {
        $time = ceil(time() / 60 * 5); // Update member account every 5 minutes
        $email = 'asphp-' . $time . '+noverify@example.com';

        $alias = new Alias();
        $alias->setType(Alias\Type::EMAIL);
        $alias->setValue($email);

        return $this->tokenIO->createBusinessMember($alias);
    }

    /**
     * @return \Tokenio\Member
     */
    public function getMember()
    {
        return $this->member;
    }

    public function generateTokenRequestUrl($data)
    {
        $destinationData = json_decode($data['destination'], true);
        $sepa = new BankAccount\Sepa();
        $sepa->setIban($destinationData['sepa']['iban']);

        $destination = new BankAccount();
        $destination->setSepa($sepa);

        $amount = $data['amount'];
        $currency = $data['currency'];
        $description = $data['description'];

        $alias = $this->member->getFirstAlias();

        $tokenBuilder = new TransferTokenBuilder($this->member, $amount, $currency);
        $tokenBuilder->setDescription($description);

        $transferEndpoint = new TransferEndpoint();
        $transferEndpoint->setAccount($destination);
        $tokenBuilder->addDestination($transferEndpoint);

        $tokenBuilder->setToAlias($alias);
        $tokenBuilder->setToMemberId($this->member->getMemberId());

        $request = TokenRequest::builder($tokenBuilder->build())
            ->addOption(TokenRequestOptions::REDIRECT_URL, 'http://localhost:9090/redeem')
            ->build();

        $requestId = $this->member->storeTokenRequest($request);

        return $this->tokenIO->generateTokenRequestUrl($requestId);
    }
}

$app->get('/', function ($request, $response, array $args) {
    $this->logger->info("Index.");
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/transfer', function ($request, $response, array $args) {
    $this->logger->info("Request transfer.");

    $tokenIo = new TokenSample();
    return $response->withRedirect($tokenIo->generateTokenRequestUrl($request->getParsedBody()), 302);
});

$app->get('/redeem', function ($request, $response, array $args) {
    $this->logger->info("Request redeem.");

    $tokenId = $request->getQueryParam('tokenId');
    if (empty($tokenId)) {
        return 'No token id found.';
    }

    $tokenIo = new TokenSample();
    $member = $tokenIo->getMember();
    $token = $member->getToken($tokenId);

    $transfer = $member->redeemToken($token);

    return 'Success! Redeemed transfer ' . $transfer->getId();
});
