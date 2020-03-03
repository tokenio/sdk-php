<?php

namespace Tokenio\Tpp;

use Grpc\Channel;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\CreateMemberType;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\TokenCluster;
use Tokenio\TokenRequest;
use Tokenio\TokenRequest\TokenRequestState;
use Tokenio\Tpp\Exception\InvalidStateException;
use Tokenio\Tpp\Rpc\ClientFactory;
use Tokenio\Tpp\TokenRequest\TokenRequestCallback;
use Tokenio\Tpp\TokenRequest\TokenRequestCallbackParameters;
use Tokenio\Tpp\TokenRequest\TokenRequestTransferDestinationsCallbackParameters;
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
     * Parse the token request callback URL to extract the state and the token ID. Check the
     * CSRF token against the initial request and verify the signature.
     *
     * @param $callbackUrl string token request callback url
     * @param $csrfToken string csrfToken
     * @return TokenRequestCallback object containing the token id and the original state
     * @throws \Tokenio\Exception\CryptoKeyNotFoundException
     * @throws \Tokenio\Exception\CryptographicException
     */
    public function parseTokenRequestCallbackUrl($callbackUrl, $csrfToken = "")
    {
        $parts = parse_url($callbackUrl);
        parse_str($parts['query'], $query);
        return self::parseTokenRequestCallbackParams($query, $csrfToken);
    }

    /**
     * Parse the Set Transfer Destinations Url callback parameters to extract state,
     * region and supported . Check the CSRF token against the initial request and verify
     * the signature.
     *
     * @param $url string token request callback url
     * @return TokenRequestCallbackParameters object containing the token id and the original state
     * @throws \Exception
     */
    public function parseSetTransferDestinationsUrl($url)
    {
        $parts = parse_url($url);
        $tempString = str_replace("supportedTransferDestinationType","supportedTransferDestinationType[]",$parts['query']);
        parse_str($tempString, $parameters);
        return self::parseSetTransferDestinationsUrlParams($parameters);
    }

    /**
     * Parse the token request callback parameters to extract the state and the token ID. Check the
     * CSRF token against the initial request and verify the signature.
     *
     * @param $callbackParams string[]
     * @param $csrfToken string CSRF token.
     * @return TokenRequestCallback
     * @throws \Tokenio\Exception\CryptoKeyNotFoundException
     * @throws \Tokenio\Exception\CryptographicException
     * @throws \Exception
     */
    public function parseTokenRequestCallbackParams($callbackParams, $csrfToken)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $tokenMember = $unauthenticated->getTokenMember();
        $params = TokenRequestCallbackParameters::create($callbackParams);
        $state = TokenRequest\TokenRequestState::parse($params->getSerializedState());
        if($state->getCsrfTokenHash()!== Util::hashString($csrfToken))
        {
            throw new InvalidStateException($csrfToken);
        }

        $payload = new TokenRequestStatePayload();
        $payload->setTokenId($params->getTokenId());
        $payload->setState(Util::urlEncode($params->getSerializedState()));
        Util::verifySignature($tokenMember, $payload, $params->getSignature());
        return new TokenRequestCallback($params->getTokenId(), $state->getInnerState());
    }

    /**
     * Parse the Set Transfer Destinations Url callback parameters to extract country,
     * bank and supported payments.
     * @param $urlParams string url parameters
     * @return TokenRequestTransferDestinationsCallbackParameters object containing region.
     * @throws \Exception
     */
    public function parseSetTransferDestinationsUrlParams($urlParams)
    {
        return TokenRequestTransferDestinationsCallbackParameters::create($urlParams);
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