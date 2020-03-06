<?php

namespace Tokenio\User;


use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Member\CreateMemberType;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\ReceiptContact;
use Io\Token\Proto\Common\Notification\AddKey;
use Io\Token\Proto\Common\Notification\DeviceMetadata;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Tokenio\DeviceInfo;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\TokenRequest;
use Tokenio\User\Rpc\ClientFactory;
use Tokenio\Util\Strings;

class TokenClient extends \Tokenio\TokenClient
{
    private $browserFactory;

    public function __construct($channel, $cryptoEngineFactory, $tokenCluster, $browserFactory)
    {
        parent::__construct($channel, $cryptoEngineFactory, $tokenCluster);
        $this->browserFactory = $browserFactory;
    }

    /**
     * @return TokenClientBuilder
     */
    public static function builder()
    {
        return new TokenClientBuilder();
    }

    /**
     * @param \Tokenio\TokenCluster $cluster
     * @param string $developerKey
     * @return TokenClient
     * @throws \Exception
     */
    public static function create($cluster, $developerKey= null)
    {
        if($developerKey !== null){
            $builder =  TokenClient::builder();
            $builder->connectTo($cluster);
            $builder->developerKey($developerKey);
            return $builder->build();
        }
        else{
            $builder =  TokenClient::builder();
            $builder->connectTo($cluster);
            return $builder->build();
        }
    }

    /**
     * @param $alias
     * @param $recoveryAgent string
     * @param $realmId string
     * @return Member
     * @throws \Exception
     */
    public function createMember($alias, $recoveryAgent= null, $realmId=null)
    {
        $member=  $this->createMemberImpl($alias, CreateMemberType::PERSONAL,null, $recoveryAgent, $realmId);

        $crypto = $this->cryptoEngineFactory->create($member->getMemberId());
        $client = ClientFactory::authenticated($this->channel, $member->getMemberId(), $crypto);
        return new Member($member->getMemberId(), $member->getPartnerId(),
                          $member->getRealmId(), $client, $member->getTokenCluster(),
                          $this->browserFactory);
    }

    /**
     * @param $alias
     * @param $realmId
     * @return Member
     * @throws \Exception
     */
    public function createMemberInRealm($alias, $realmId)
    {
        return $this->createMember($alias, $realmId, $realmId);
    }

    /**
     * @param $alias Alias
     * @param $memberId string
     * @return Member
     * @throws \Exception
     */
    public function setUpMember($alias, $memberId)
    {
        $crypto = $this->cryptoEngineFactory->create($memberId);
        $client = ClientFactory::authenticated($this->channel, $memberId, $crypto);
        $mem = $this->setUpMemberImpl($alias, $memberId, null);
        return new Member($mem->getMemberId(),$mem->getPartnerId(),$mem->getRealmId(), $client, $mem->getTokenCluster(), $this->browserFactory);
    }

    /**
     * @param $memberId string
     * @return Member
     * @throws \Exception
     */
    public function getMember($memberId)
    {
        $crypto = $this->cryptoEngineFactory->create($memberId);
        $client = ClientFactory::authenticated($this->channel, $memberId, $crypto);
        $mem = $this->getMemberImpl($memberId, $client);
        return new Member($mem->getMemberId(),$mem->getPartnerId(),$mem->getRealmId(), $client, $mem->getTokenCluster(), $this->browserFactory);
    }

    /**
     * Completes account recovery.
     *
     * @param string $memberId the member id
     * @param MemberRecoveryOperation[] $recoveryOperations the member recovery operations
     * @param Key $privilegedKey the privileged public key in the member recovery operations
     * @param CryptoEngineInterface $cryptoEngine the new crypto engine
     * @return Member updatedMember
     */
    public function completeRecovery($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine)
    {
       $mem = $this->completeRecoveryImpl($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine);
       $client = ClientFactory::authenticated($this->channel, $mem->getMemberId(), $cryptoEngine);
       return new Member($mem->getMemberId(),$mem->getPartnerId(),$mem->getRealmId(), $client, $mem->getTokenCluster(), $this->browserFactory);
    }

    /**
     * @param $memberId string
     * @param $verificationId string
     * @param $code string
     * @param $cryptoEngine CryptoEngineInterface
     * @return Member
     */
    public function completeRecoveryWithDefaultRule($memberId, $verificationId, $code, $cryptoEngine)
    {
        $mem = $this->completeRecoveryWithDefaultRuleImpl($memberId, $verificationId, $code, $cryptoEngine);
        $client = ClientFactory::authenticated($this->channel, $mem->getMemberId(), $cryptoEngine);
        return new Member($mem->getMemberId(),$mem->getPartnerId(),$mem->getRealmId(), $client, $mem->getTokenCluster(), $this->browserFactory);
    }

    /**
     * @param $alias Alias
     * @return DeviceInfo
     */
    public function provisionDevice($alias)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $memberId = $unauthenticated->getMemberId($alias);
        $crypto = $this->cryptoEngineFactory->create($memberId);
        return new DeviceInfo($memberId, array($crypto->generateKey(Key\Level::PRIVILEGED),
                                                $crypto->generateKey(Key\Level::STANDARD),
                                                $crypto->generateKey(Key\Level::LOW)));
    }

    /**
     * @param $alias Alias
     * @param $keys Key[]
     * @param $deviceMetadata DeviceMetadata
     * @return int
     */
    public function notifyAddKey($alias, $keys, $deviceMetadata)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $addKey = new AddKey();
        $addKey->setKeys($keys)->setDeviceMetadata($deviceMetadata);

        return $unauthenticated->notifyAddKey($alias, $addKey);
    }

    /**
     * @param $tokenPayload TokenPayload
     * @return int
     */
    public function notifyPaymentRequest($tokenPayload)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        if($tokenPayload->getRefId() === null || empty($tokenPayload->getRefId()))
        {
            $tokenPayload = $tokenPayload->setRefId(Strings::generateNonce());
        }
        return $unauthenticated->notifyPaymentRequest($tokenPayload);
    }

    /**
     * @param $tokenrequestId string
     * @param $keys Key[]
     * @param $deviceMetadata DeviceMetadata
     * @param $receiptContact ReceiptContact
     * @return NotifyResult
     */
    public function notifyCreateAndEndorseToken($tokenrequestId, $keys, $deviceMetadata, $receiptContact)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $key =new AddKey();
        $key->setKeys($keys)->setDeviceMetadata($deviceMetadata);
        return $unauthenticated->notifyCreateAndEndorseToken($tokenrequestId, $key, $receiptContact);
    }

    /**
     * @param $notificationId string
     * @return int
     */
    public function invalidateNotification($notificationId)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->invalidateNotification($notificationId);
    }

    /**
     * @param $blobId string
     * @return Blob
     */
    public function getBlob($blobId)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->getBlob($blobId);
    }

    /**
     * @param $tokenRequestId string
     * @return TokenRequest\TokenRequestResult
     */
    public function getTokenRequestResult($tokenRequestId)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->getTokenRequestResult($tokenRequestId);
    }

    /**
     * @param $requestId string
     * @return TokenRequest
     */
    public function retrieveTokenRequest($requestId)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->retrieveTokenRequest($requestId);
    }

    /**
     * @param $requestId string
     * @param $options TokenRequestOptions
     * @return \Io\Token\Proto\Gateway\UpdateTokenRequestResponse
     */
    public function updateTokenRequest($requestId, $options)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->updateTokenRequest($requestId, $options);
    }

}