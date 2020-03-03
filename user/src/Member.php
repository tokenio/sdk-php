<?php

namespace Tokenio\User;




use Google\Protobuf\Internal\Message;
use Google\Protobuf\Internal\RepeatedField;
use GPBMetadata\Money;
use Io\Token\Proto\Banklink\BankAuthorization;
use Io\Token\Proto\Banklink\OauthBankAuthorization;
use Io\Token\Proto\Common\Blob\Blob\AccessMode;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\ReceiptContact;
use Io\Token\Proto\Common\Notification\Notification\Status;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Io\Token\Proto\Common\Subscriber\Subscriber;
use Io\Token\Proto\Common\Token\BulkTransferBody;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Transfer\BulkTransfer;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Gateway\CreateTokenRequest;
use Io\Token\Proto\Gateway\CreateTokenResponse;
use Io\Token\Proto\Gateway\GetTokensRequest;
use Io\Token\Proto\Gateway\UnlinkAccountsResponse;
use Io\Token\Proto\Gateway\UnsubscribeFromNotificationsResponse;
use Io\Token\Proto\Gateway\UpdateNotificationStatusResponse;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Util\Type;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\PagedList;
use Tokenio\TokenRequest\Builder\StandingOrderBuilder;
use Tokenio\User\Browser\Browserfactory;
use Tokenio\User\Rpc\Client;
use Tokenio\User\Util\Util;
use Tokenio\Util\Strings;


class Member extends \Tokenio\Member
{

    /* @var Client $client */
    protected $client;

    private $browserFactory;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct($memberId, $partnerId, $realmId , $client, $cluster, $browserFactory)
    {
        parent::__construct($memberId, $partnerId, $realmId, $client, $cluster);

        $this->client = $client;
        $this->browserFactory = $browserFactory;
        $this->logger = new Logger('Tokenio\User\StandingOrderTokenBuilder');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
    }

    /**
     * Links a funding bank account to Token and returns it to the caller.
     *
     * @return Account[]
     * @throws \Exception
     */
    public function getAccounts()
    {
        $accounts = parent::getAccountsImpl();
        $result = [];

        /* @var \Tokenio\Account $account */
        foreach ($accounts as $account) {
            $result[] = new Account($this, $this->client, $account);
        }

        return $result;
    }

    /**
     * Looks up a funding bank account linked to Token.
     *
     * @param $accountId string
     * @return Account
     * @throws \Exception
     */
    public function getAccount($accountId)
    {
       $acc= $this->getAccountImpl($accountId);
       return new Account($this, $this->client, $acc);
    }


    /**
     * @param $accountId string
     * @return Message
     * @throws \Exception
     */
    public function setDefaultAccount($accountId)
    {
        return $this->client->setDefaultAccount($accountId);
    }

    /**
     * @return Account
     * @throws \Exception
     */
    public function getDefaultAccount()
    {
        $account = $this->client->getDefaultAccount($this->getMemberId());
        return new Account($this, $this->client, null, $account);
    }

    /**
     * @param $transferId
     * @return Transfer
     * @throws \Exception
     */
    public function getTransfer($transferId)
    {
        return $this->client->getTransfer($transferId);
    }

    /**
     * @param $bulkTransferId
     * @return BulkTransfer
     * @throws \Exception
     */
    public function getBulkTransfer($bulkTransferId)
    {
        return $this->client->getBulkTransfer($bulkTransferId);
    }

    /**
     * @param $submissionId string
     * @return mixed
     * @throws \Exception
     */
    public function getStandingOrderSubmission($submissionId)
    {
        return $this->client->getStandingOrderSubmission($submissionId);
    }

    /**
     * @param null $offset
     * @param $limit int
     * @param null $tokenId
     * @return PagedList
     * @throws \Exception
     */
    public function getTransfers($offset, $limit, $tokenId)
    {
        return $this->client->getTransfers($offset, $limit, $tokenId);
    }

    /**
     * @param $offset string
     * @param $limit int
     * @return PagedList
     * @throws \Exception
     */
    public function getStandingOrderSubmissions($limit, $offset= null)
    {
        return $this->client->getStandingOrderSubmissions($limit, $offset);
    }


    /**
     * @param $transferTokenBuilder TransferTokenBuilder
     * @return PrepareTokenResult
     * @throws \Exception
     */
    public function prepareTransferToken($transferTokenBuilder)
    {
        $transferTokenBuilder->from($this->getMemberId());
        return $this->client->prepareToken($transferTokenBuilder->buildPayload());
    }


    /**
     * @param $builder BulkTransferTokenBuilder
     * @return PrepareTokenResult
     * @throws \Exception
     */
    public function prepareBulkTransferToken($builder)
    {
        return $this->client->prepareToken($builder->buildPayload());
    }

    /**
     * @param $accessTokenBuilder AccessTokenBuilder
     * @return PrepareTokenResult
     * @throws \Exception
     */
    public function prepareAccessToken($accessTokenBuilder)
    {
        $accessTokenBuilder->from($this->getMemberId());
        return $this->client->prepareToken($accessTokenBuilder->build());
    }

    /**
     * @param $builder StandingOrderTokenBuilder
     * @return PrepareTokenResult
     * @throws \Exception
     */
    public function prepareStandingOrderToken($builder)
    {
        return $this->client->prepareToken($builder->buildPayload());
    }

    /**
     * @param $payload TokenPayload
     * @param $tokenRequestId string
     * @param $keyLevel int
     * @param $signatures Signature[]
     * @return Token
     * @throws \Exception
     */
    public function createToken($payload, $tokenRequestId= null , $keyLevel= null, $signatures= null)
    {
        if($keyLevel === null)
        {
            return $this->client->createToken($payload, $tokenRequestId, $signatures);
        }
        else{
            /* @var Signature[] $signatures */
            $signatures = [];
            $signatures[] = $this->signTokenPayload($payload, $keyLevel);
            return $this->client->createToken($payload, $tokenRequestId, $signatures);
        }
    }

    /**
     * @param $tokenRequest TokenRequest
     * @param $tokenPayload TokenPayload
     * @param $amount int
     * @param $currency string
     * @return TransferTokenBuilder
     * @throws \Tokenio\Exception\IllegalArgumentException
     */
    public function createTransferTokenBuilder($tokenRequest, $tokenPayload= null, $amount= null, $currency= null)
    {
        if($tokenRequest != null)
        {
            return new TransferTokenBuilder($tokenRequest, $this);
        }
        elseif ($tokenPayload != null)
        {
            return new TransferTokenBuilder(null, $this, $tokenPayload);
        }
        elseif ($amount !== null and  $currency !== null){
            return new TransferTokenBuilder(null, $this, null, $amount, $currency);
        }
    }

    /**
     * @param $tokenRequest TokenRequest
     * @param $transfers BulkTransferBody\Transfer[]
     * @param $totalAmount int
     * @param $source TransferEndpoint
     * @return BulkTransferTokenBuilder
     * @throws \Exception
     */
    public function createBulkTransferTokenBuilder($tokenRequest, $transfers, $totalAmount, $source)
    {
        return new BulkTransferTokenBuilder($tokenRequest, $this, $transfers, $totalAmount, $source);

    }

    /**
     * @param $tokenRequest TokenRequest
     * @param  $amount int
     * @param $currency string
     * @param $frequency string
     * @param $startDate string
     * @param $endDate string
     * @return StandingOrderTokenBuilder
     * @throws \Exception
     */
    public function createStandingOrderTokenBuilder($tokenRequest, $amount, $currency, $frequency, $startDate, $endDate=null)
    {
        return new StandingOrderTokenBuilder($tokenRequest, $this, $amount, $currency, $frequency, $startDate, $endDate);
    }


    /**
     * @param $tokenRequest TokenRequest
     * @param $payload TokenPayload
     * @param $amount
     * @param $currency
     * @param null $tokenRequestId
     * @return Token|TransferTokenBuilder
     * @throws \Exception
     */
    public function createTransferToken($tokenRequest, $payload, $amount, $currency, $tokenRequestId=null)
    {
        if($payload === null) {
            return $this->createTransferTokenBuilder($tokenRequest, null, $amount, $currency);
        }
        else{
            return $this->client->createTransferToken($payload, $tokenRequestId);
        }
    }

    /**
     * @param $accessTokenBuilder AccessTokenBuilder
     * @return Token
     * @throws \Exception
     */
    public function createAccessToken($accessTokenBuilder)
    {
        return $this->client->createAccessToken($accessTokenBuilder->from($this->getMemberId())->build(), $accessTokenBuilder->getTokenRequestId());
    }

    /**
     * @param $token Token
     * @param $keyLevel int
     * @return TokenOperationResult
     * @throws \Exception
     */
    public function endorseToken($token, $keyLevel)
    {
        return $this->client->endorseToken($token, $keyLevel);
    }

    /**
     * @param $token Token
     * @return TokenOperationResult
     * @throws \Exception
     */
    public function cancelToken($token)
    {
        return $this->client->cancelToken($token);
    }

    /**
     * @param $tokenToCancel Token
     * @param $tokenToCreate AccessTokenBuilder
     * @return TokenOperationResult
     * @throws \Exception
     */
    public function replaceAccessToken($tokenToCancel, $tokenToCreate)
    {
        return $this->client->replace($tokenToCancel, $tokenToCreate->from($this->getMemberId())->build());
    }

    /**
     * @param $contact ReceiptContact
     * @return Message
     * @throws \Exception
     */
    public function setReceiptContact($contact)
    {
        return $this->client->setReceiptContact($contact);
    }

    /**
     * @return ReceiptContact
     * @throws \Exception
     */
    public function getReceiptContact()
    {
        return $this->client->getReceiptContact();
    }

    /**
     * @param $toMemberId string
     * @throws \Exception
     */
    public function getActiveAccessToken($toMemberId)
    {
        return $this->client->getActiveAccessToken($toMemberId);
    }

    /**
     * @param $offset string
     * @param $limit int
     * @return PagedList
     * @throws \Exception
     */
    public function getTransferTokens($offset, $limit)
    {
        return $this->client->getTokens(GetTokensRequest\Type::TRANSFER, $offset, $limit);
    }

    /**
     * @param $offset string
     * @param $limit int
     * @return PagedList
     * @throws \Exception
     */
    public function getAccessTokens($offset, $limit)
    {
        return $this->client->getTokens(GetTokensRequest\Type::ACCESS, $offset, $limit);
    }

    /**
     * @param $tokenId string
     * @return mixed
     * @throws \Exception
     */
    public function getToken($tokenId)
    {
        return $this->client->getToken($tokenId);
    }

    /**
     * @param $token Token
     * @param $amount int
     * @param $currency string
     * @param $description string
     * @param $destination
     * @param $refId string
     * @return Transfer
     * @throws \Exception
     */
    public function redeemToken($token, $amount = null, $currency = null, $description = null, $destination = null, $refId = null)
    {
        if(! $token->getPayload()->getTransfer())
        {
            throw new IllegalArgumentException("Expected transfer token; found".$token->getPayload()->getBody());

        }
        $payload = new TransferPayload();
        $payload->setTokenId($token->getId());
        $payload->setDescription($token->getPayload()->getDescription());

        if ($destination != null) {
            if($destination instanceof TransferDestination)
            {
                $payload->getTransferDestinations()[] = $destination;
            }
            elseif($destination instanceof TransferEndpoint){
                $payload->getDestinations()[] = $destination;
            }
        }
        if ($amount != null) {
            $payload->getAmount()->setValue(strval($amount));
        }
        if ($currency != null) {
            $payload->getAmount()->setCurrency($currency);
        }
        if ($description != null) {
            $payload->setDescription($description);
        }
        if ($refId != null) {
            $payload->setRefId($refId);
        } else if ($amount == null || strval($amount) === $token->getPayload()->getTransfer()->getLifetimeAmount()) {
            $payload->setRefId($token->getPayload()->getRefId());
        } else {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $payload->setRefId(Strings::generateNonce());
        }

        return $this->client->createTransfer($payload);
    }


    /**
     * Redeems a transfer token.
     *
     * NOTE: destination should have type TransferDestination. Support for TransferEndpoint will be removed.
     *
     * @param Token $token the transfer token
     * @param double $amount the amount to transfer
     * @param string $currency the currency
     * @param string $description the description of the transfer
     * @param  $destination
     * @param string $refId the reference id of the transfer
     * @return Transfer
     * @throws \Exception
     */
    public function redeemTokenInternal($token, $amount = null, $currency = null, $description = null, $destination = null, $refId = null)
    {
        $payload = new TransferPayload();
        $payload->setTokenId($token->getId());
        $payload->setDescription($token->getPayload()->getDescription());

        if ($destination != null) {
            if($destination instanceof TransferDestination)
            {
                $payload->getTransferDestinations()[] = $destination;
            }
            elseif($destination instanceof TransferEndpoint){
                $payload->getDestinations()[] = $destination;
            }
        }
        if ($amount != null) {
            $payload->getAmount()->setValue(strval($amount));
        }
        if ($currency != null) {
           $payload->getAmount()->setCurrency($currency);
        }
        if ($description != null) {
            $payload->setDescription($description);
        }
        if ($refId != null) {
            $payload->setRefId($refId);
        } else if ($amount == null || strval($amount) === $token->getPayload()->getTransfer()->getLifetimeAmount()) {
            $payload->setRefId($token->getPayload()->getRefId());
        } else {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $payload->setRefId(Strings::generateNonce());
        }

        return $this->client->createTransfer($payload);
    }

    /**
     * @param $tokenId string
     * @return BulkTransfer
     * @throws \Exception
     */
    public function redeemBulkTransferToken($tokenId)
    {
        return $this->client->createBulkTransfer($tokenId);
    }

    /**
     * @param $tokenId string
     * @return StandingOrderSubmission
     * @throws \Exception
     */
    public function redeemStandingOrderToken($tokenId)
    {
        return $this->client->createStandingOrder($tokenId);
    }

    /**
     * @param $authorization BankAuthorization
     * @param $bankId string
     * @param $accessToken string
     * @return RepeatedField
     * @throws \Exception
     */
    public function linkAccounts($authorization, $bankId= null, $accessToken= null)
    {
        if($authorization !== null){
            return $this->toAccountList($this->client->linkAccounts($authorization));
        }
        else{
            $newAuthorization = new OauthBankAuthorization();
            $newAuthorization->setBankId($bankId)
                ->setAccessToken($accessToken);

            return $this->toAccountList($this->client->linkAccounts($newAuthorization));
        }
    }

    /**
     * @param $accountIds string[]
     * @return UnlinkAccountsResponse
     * @throws \Exception
     */
    public function unlinkAccounts($accountIds)
    {
        return $this->client->unlinkAccounts($accountIds);
    }

    /**
     * @param $accountId string
     * @param $keyLevel int
     * @return \Io\Token\Proto\Common\Money\Money
     * @throws \Exception
     */
    public function getCurrentBalance($accountId, $keyLevel)
    {
        return $this->client->getBalance($accountId, $keyLevel)->getCurrent();
    }

    /**
     * @param $accountId string
     * @param $keyLevel int
     * @return \Io\Token\Proto\Common\Money\Money
     * @throws \Exception
     */
    public function getAvailableBalance($accountId, $keyLevel)
    {
        return $this->client->getBalance($accountId, $keyLevel)->getAvailable();
    }

    /**
     * @throws \Exception
     */
    public function removeNonStoredKeys()
    {
        $storedKeys = $this->client->getCryptoEngine()->getPublicKeys();
        $member = $this->client->getMember($this->getMemberId());
        $keys = $member->getKeys();
        $toRemoveIds = array();

        /* @var $key Key */
        foreach ($keys as $key) {
            if(!in_array($key, $storedKeys)) {
                $toRemoveId[] = $key->getId();
            }
        }
        return $this->removeKeys($toRemoveIds);
    }

    /**
     * @param $profile Profile
     * @return Profile
     * @throws \Exception
     */
    public function setProfile($profile)
    {
        return $this->client->setProfile($profile);
    }


    /**
     * Replaces auth'd member's public profile picture.
     *
     * @param string $type MIME type of picture
     * @param string $data byte array representation image data
     * @return bool that indicates whether the operation finished or had an error
     * @throws \Exception
     */
    public function setProfilePicture($type, $data)
    {
        $payload = new Payload();
        $payload->setOwnerId($this->getMemberId())
            ->setType($type)
            ->setName('profile')
            ->setData($data)
            ->setAccessMode(AccessMode::PBPUBLIC);

        return $this->client->setProfilePicture($payload);
    }

    /**
     * @param $offset string
     * @param $limit int
     * @return PagedList
     * @throws \Exception
     */
    public function getNotifications($offset = null, $limit)
    {
        return $this->client->getNotifications($offset, $limit);
    }

    /**
     * @param $notificationId string
     * @throws \Exception
     */
    public function getNotification($notificationId)
    {
        return $this->client->getNotification($notificationId);
    }

    /**
     * @param $notificationId string
     * @param $status int
     * @return UpdateNotificationStatusResponse
     * @throws \Exception
     */
    public function updateNotificationStatus($notificationId, $status)
    {
        return $this->client->updateNotificationStatus($notificationId, $status);
    }

    /**
     * @param $subscriberId string
     * @return UnsubscribeFromNotificationsResponse
     * @throws \Exception
     */
    public function unsubscribeFromNotifications($subscriberId)
    {
        return $this->client->unsubscribeFromNotifications($subscriberId);
    }

    /**
     * @param $handler string
     * @param $handlerInstructions string[]
     * @return Subscriber
     * @throws \Exception
     */
    public function subscribeToNotifications($handler, $handlerInstructions= array())
    {
        return $this->client->subscribeToNotifications($handler, $handlerInstructions);
    }

    /**
     * @return RepeatedField
     * @throws \Exception
     */
    public function getSubscribers()
    {
        return $this->client->getSubscribers();
    }

    /**
     * @param $subscriberId string
     * @return Subscriber
     * @throws \Exception
     */
    public function getSubscriber($subscriberId)
    {
        return $this->client->getSubscriber($subscriberId);
    }

    /**
     * @param $tokenRequestId string
     * @param $tokenId string
     * @param $state string
     * @return Signature
     * @throws \Exception
     */
    public function signTokenRequestState($tokenRequestId, $tokenId, $state)
    {
        return $this->client->signTokenRequestState($tokenRequestId, $tokenId, $state);
    }

    /**
     * @param $callbackUrl string
     * @param $tokenRequestId string
     * @return string inking request ID
     * @throws \Exception
     */
    public function storeLinkingRequest($callbackUrl, $tokenRequestId)
    {
        return $this->client->storeLinkingRequest($callbackUrl, $tokenRequestId);
    }

    /**
     * @param $accountIds string[]
     * @return string
     * @throws \Exception
     */
    public function applySca($accountIds)
    {
        return $this->client->applySca($accountIds);
    }

    /**
     * @param $balance double
     * @param $currency string
     * @return Account
     * @throws \Exception
     */
    public function createTestBankAccount($balance, $currency)
    {
        $testAccount = $this->createTestBankAccountImpl($balance, $currency);
        return new Account($this, $this->client, $testAccount);
    }

    /**
     * @param $accounts
     */
    public function toAccountList($accounts)
    {
        $result= [];

        /* @var $account \Io\Token\Proto\Common\Account\Account */
        foreach($accounts as $account){
            $result[] = new Account($this, $this->client, null, $account);
        }
        return $result;
    }

    /**
     * @param $account \Io\Token\Proto\Common\Account\Account
     * @return Account
     */
    public function toAccount($account)
    {
        return new Account($this, $this->client, null, $account);
    }

    /**
     * @param $appCallbackUrl string
     * @return Message
     * @throws \Exception
     */
    public function setAppCallbackUrl($appCallbackUrl)
    {
        return $this->client->setAppCallbackUrl($appCallbackUrl);
    }
}