<?php

namespace Tokenio\Tpp;

use Grpc\Channel;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\CreateMemberType;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Security\Key;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\TokenCluster;
use Tokenio\TokenRequest;
use Tokenio\TokenRequest\TokenRequestState;
use Tokenio\Tpp\Rpc\ClientFactory;
use Tokenio\Tpp\Util\Util;

class TokenClient extends \Tokenio\TokenClient
{
    const TOKEN_REQUEST_TEMPLATE = "https://%s/request-token/%s?state=%s";

    /**
     * Creates an instance of a Token SDK.
     *
     * @param Channel $channel the gRPC channel
     * @param TokenCluster $tokenCluster the token cluster to connect to
     * @param CryptoEngineFactoryInterface $cryptoEngineFactory the crypto factory to create crypto engine
     */
    public function __construct($channel, $cryptoEngineFactory, $tokenCluster)
    {
        parent::__construct($channel, $cryptoEngineFactory, $tokenCluster);
    }

    /**
     * @return TokenClientBuilder
     */
    public static function builder()
    {
        return new TokenClientBuilder();
    }

    /**
     * Creates a new instance of {@link TokenClient} that's configured to use
     * the specified environment.
     *
     * @param TokenCluster $cluster token cluster to connect to
     * @param string $developerKey developer key
     * @return \Tokenio\Tpp\TokenClient
     * @throws \Exception
     */
    public static function create($cluster, $developerKey)
    {
        $builder =  TokenClient::builder();
        $builder->connectTo($cluster);
        $builder->developerKey($developerKey);
        return $builder->build();
    }


    /**
    * @param $alias Alias must be unique . If null, then no alias will be created with the member.
    * @param  $partnerId string ID of partner member
    * @param  $realmId string  member Id of existing member to which this new member is associated with
    * @return Member newly created member
    * @throws \Exception
    */
    public function createMember($alias, $partnerId= null, $realmId=null)
    {
        /** @var \Tokenio\Member $mem */
        $mem= $this->createMemberImpl($alias, CreateMemberType::BUSINESS, $partnerId, null, $realmId);
        $crypto = $this->cryptoEngineFactory->create($mem->getMemberId());
        $client = ClientFactory::authenticated($this->channel, $mem->getMemberId(), $crypto);
        return new Member($mem->getMemberId(), $mem->getPartnerId(), $mem->getRealmId(), $client, $mem->getTokenCluster());
    }

    /**
     * @param $alias Alias must be unique . If null, then no alias will be created with the member.
     * @param $realmId string member id of an existing Member to whose realm this new member belongs.
     * @return Member newly created member
     * @throws \Exception
     */
    public function createMemberInRealm($alias, $realmId)
    {
        return $this->createMember($alias,null, $realmId);
    }

    /**
     * @param $alias Alias must be unique . If null, then no alias will be created with the member.
     * @param $memberId string member id.
     * @return \Tokenio\Member newly created member.
     * @throws \Exception
     */
    public function setUpMember($alias, $memberId)
    {
        $crypto = $this->cryptoEngineFactory->create($memberId);
        $client = ClientFactory::authenticated($this->channel, $memberId, $crypto);
        $mem = $this->setUpMemberImpl($alias, $memberId, null);
        return new Member($mem->getMemberId(), $mem->getPartnerId(), $mem->getRealmId(), $client, $mem->getTokenCluster());
    }

    /**
     * Return a Member set up to use some Token member's keys (assuming we have them).
     *
     * @param $memberId string member id
     * @return Member
     * @throws \Exception
     */
    public function getMember($memberId)
    {
        $crypto = $this->cryptoEngineFactory->create($memberId);
        $client = ClientFactory::authenticated($this->channel, $memberId, $crypto);
        $mem = $this->getMemberImpl($memberId, $client);
        return new Member($mem->getMemberId(), $mem->getPartnerId(), $mem->getRealmId(), $client, $mem->getTokenCluster());
    }

    /**
     * Completes account recovery.
     * @param $memberId string the member id.
     * @param $recoveryOperations MemberRecoveryOperation[] the member recovery operations.
     * @param $privilegedKey Key the privileged public key in the member recovery operations
     * @param $cryptoEngine CryptoEngineInterface the new crypto engine
     * @return \Tokenio\Member an observable of the updated member
     */
    public function completeRecovery($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine)
    {
        $mem = $this->completeRecoveryImpl($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine);
        $client = ClientFactory::authenticated($this->channel, $mem->getMemberId(), $cryptoEngine);
        return new Member($mem->getMemberId(), $mem->getPartnerId(), $mem->getRealmId(), $client, $mem->getTokenCluster());
    }

    /**
     * @param $memberId string member id.
     * @param $verificationId string verification id.
     * @param $code string
     * @param $cryptoEngine CryptoEngineInterface new crypto Engine.
     * @return Member
     */
    public function completeRecoveryWithDefaultRule($memberId, $verificationId, $code, $cryptoEngine)
    {
        $mem = $this->completeRecoveryWithDefaultRuleImpl($memberId, $verificationId, $code, $cryptoEngine);
        $client = ClientFactory::authenticated($this->channel, $mem->getMemberId(), $cryptoEngine);
        return new Member($mem->getMemberId(), $mem->getPartnerId(), $mem->getRealmId(), $client, $mem->getTokenCluster());
    }

    /**
     * @param string  $requestId
     * @param string $state
     * @param string $csrfToken
     * @return string
     */
    public function generateTokenRequestUrl($requestId, $state = "", $csrfToken = "")
    {
        $csrfTokenHash = Util::hashString($csrfToken);

        /** @var  $tokenRequestState  TokenRequestState */
        $tokenRequestState = new TokenRequestState($csrfTokenHash, $state);
        return sprintf(self::TOKEN_REQUEST_TEMPLATE,
            $this->tokenCluster->getWebUrl(),
            $requestId,
            Util::urlEncode($tokenRequestState->serialize()));
    }

    /**
     * Get the token request result based on a token's tokenRequestId.
     *
     * @param string tokenRequestId the token request id
     * @return TokenRequest\TokenRequestResult the token request result
     */
    public function getTokenRequestResult($tokenRequestId)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->getTokenRequestResult($tokenRequestId);
    }

    /**
     * Returns a token request for a specified token request id.
     *
     * @param string $requestId the request id
     * @return TokenRequest the token request
     */
    public function retrieveTokenRequest($requestId)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->retrieveTokenRequest($requestId);
    }
}