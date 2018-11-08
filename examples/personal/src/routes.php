<?php

use Io\Token\Proto\Common\Alias\Alias;
use Tokenio\Config\TokenCluster;
use Tokenio\Config\TokenEnvironment;
use Tokenio\Config\TokenIoBuilder;
use Tokenio\Http\Request\TokenRequest;
use Tokenio\Http\Request\TokenRequestOptions;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\Util\Strings;

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

    public function generateTokenRequestUrl()
    {
        $alias = $this->member->getFirstAlias();
        $tokenBuilder = \Tokenio\Http\Request\AccessTokenBuilder::createWithAlias($alias)->forAll();

        $request = TokenRequest::builder($tokenBuilder->build())
            ->addOption(TokenRequestOptions::REDIRECT_URL, 'http://localhost:9090/fetch-balances')
            ->build();

        $requestId = $this->member->storeTokenRequest($request);

        return $this->tokenIO->generateTokenRequestUrl($requestId);
    }
}

$app->get('/', function ($request, $response, array $args) {
    $this->logger->info("Index.");
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/request-balances', function ($request, $response, array $args) {
    $this->logger->info("Request balances.");

    $tokenIo = new TokenSample();
    return $response->withRedirect($tokenIo->generateTokenRequestUrl(), 302);
});

$app->get('/fetch-balances', function ($request, $response, array $args) {
    $this->logger->info("Fetch balances.");

    $tokenId = $request->getQueryParam('tokenId');
    if (empty($tokenId)) {
        return 'No token id found.';
    }

    $tokenIo = new TokenSample();
    $member = $tokenIo->getMember();

    $member->useAccessToken($tokenId, false);
    $token = $member->getToken($tokenId);

    $resources = $token->getPayload()->getAccess()->getResources();

    $accounts = array();
    /** @var \Io\Token\Proto\Common\Token\AccessBody\Resource $resource */
    foreach ($resources as $resource) {
        if ($resource->getAccount() == null) {
            continue;
        }

        if (!empty($resource->getAccount()->getAccountId())) {
            $accounts[] = $resource->getAccount()->getAccountId();
        }
    }

    $balances = array();
    foreach ($accounts as $accountId) {
        $account = $member->getAccount($accountId);
        $current = $account->getCurrentBalance(\Io\Token\Proto\Common\Security\Key\Level::STANDARD);
        $balances[] = sprintf('%s %s', $current->getValue(), $current->getCurrency());
    }

    $member->clearAccessToken();

    $data = array('balances' => $balances);
    return $response->withJson($data);
});
