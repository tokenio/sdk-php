<?php

namespace Tokenio;

use Grpc\Channel;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\CreateMemberType;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Io\Token\Proto\Gateway\GetBanksResponse;
use Tokenio\Config\TokenClientBuilder;
use Tokenio\Config\TokenCluster;
use Tokenio\Config\TokenIoBuilder;
use Tokenio\Exception\InvalidStateException;
use Tokenio\Exception\VerificationException;
use Tokenio\Http\ClientFactory;
use Tokenio\Http\Request\TokenRequestCallback;
use Tokenio\Http\Request\TokenRequestCallbackParameters;
use Tokenio\Http\Request\TokenRequestResult;
use Tokenio\Http\Request\TokenRequestState;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\Util\Util;

class TokenClient
{
    const TOKEN_REQUEST_TEMPLATE = 'https://%s/request-token/%s?state=%s';

    /**
     * @return TokenClientBuilder
     */
    public static function builder()
    {
        return new TokenClientBuilder();
    }

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var TokenCluster
     */
    private $tokenCluster;

    /**
     * @var CryptoEngineFactoryInterface
     */
    private $cryptoEngineFactory;

    /**
     * Creates an instance of a Token SDK.
     *
     * @param Channel $channel the gRPC channel
     * @param TokenCluster $tokenCluster the token cluster to connect to
     * @param CryptoEngineFactoryInterface $cryptoEngineFactory the crypto factory to create crypto engine
     */
    public function __construct($channel, $tokenCluster, $cryptoEngineFactory)
    {
        $this->channel = $channel;
        $this->tokenCluster = $tokenCluster;
        $this->cryptoEngineFactory = $cryptoEngineFactory;
    }

    /**
     * Checks if a given alias already exists.
     *
     * @param Alias $alias to check
     * @return bool {@code true} if alias exists, {@code false} otherwise
     */
    public function isAliasExists($alias)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->aliasExists($alias);
    }

    /**
     * Looks up member id for a given alias.
     *
     * @param Alias $alias to check
     * @return string member id, or throws exception if member not found
     */
    public function getMemberId($alias)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->getMemberId($alias);
    }

    /**
     * Creates a new Token member with a set of auto-generated keys, an alias, and member type.
     *
     * @param Alias $alias nullable member alias to use, must be unique. If null, then no alias will
     *     be created with the member.
     * @param int $memberType the type of member to register
     * @param string tokenRequestId (optional) token request id. If used, then the member will be claimed
     *     by the creator of the corresponding token request. Only works if memberType == TRANSIENT.
     * @return \Tokenio\Member newly created member
     * @throws Exception\CryptographicException
     */
    public function createMember($alias = null, $memberType = CreateMemberType::PERSONAL)
    {
        $unauthenticatedClient = ClientFactory::unauthenticated($this->channel);
        $agentId = $unauthenticatedClient->getDefaultAgent();
        $memberId = $unauthenticatedClient->createMemberId($memberType);

        $crypto = $this->cryptoEngineFactory->create($memberId);

        $operations = array();
        $metadata = array();
        $operations[] = Util::createAddKeyMemberOperation($crypto->generateKey(Key\Level::PRIVILEGED));
        $operations[] = Util::createAddKeyMemberOperation($crypto->generateKey(Key\Level::STANDARD));
        $operations[] = Util::createAddKeyMemberOperation($crypto->generateKey(Key\Level::LOW));
        $operations[] = Util::createRecoveryAgentOperation($agentId);

        if ($alias != null) {
            $operations[] = Util::createAddAliasOperation(Util::normalizeAlias($alias));
            $metadata[] = Util::createAddAliasOperationMetadata(Util::normalizeAlias($alias));
        }

        $signer = $crypto->createSigner(Key\Level::PRIVILEGED);

        $createdMember = $unauthenticatedClient->createMember($memberId, $operations, $metadata, $signer);
        $crypto = $this->cryptoEngineFactory->create($createdMember->getId());
        $client = ClientFactory::authenticated($this->channel, $createdMember->getId(), $crypto);

        return new Member($client);
    }

    /**
     * Creates a new business-use Token member with a set of auto-generated keys and alias.
     *
     * @param Alias $alias the alias to associated with member
     * @return \Tokenio\Member the created member
     * @throws Exception\CryptographicException
     */
    public function createBusinessMember($alias)
    {
        return $this->createMember($alias, CreateMemberType::BUSINESS);
    }

    /**
     * Return a Member set up to use some Token member's keys (assuming we have them).
     *
     * @param $memberId string member id
     * @return \Tokenio\Member
     */
    public function getMember($memberId)
    {
        $crypto = $this->cryptoEngineFactory->create($memberId);
        $client = ClientFactory::authenticated($this->channel, $memberId, $crypto);
        $client->getMember($memberId);

        return new Member($client);
    }

    /**
     * Returns a list of token enabled banks.
     *
     * @param string[] $ids If specified, return banks whose 'id' matches any one of the given ids
     *     (case-insensitive). Can be at most 1000.
     * @param string $search If specified, return banks whose 'name' or 'identifier' contains the given
     *     search string (case-insensitive)
     * @param string $country If specified, return banks whose 'country' matches the given ISO 3166-1
     *     alpha-2 country code (case-insensitive)
     * @param int $page Result page to retrieve. Default to 1 if not specified.
     * @param int $perPage Maximum number of records per page. Can be at most 200. Default to 200
     *     if not specified.
     * @param string $sort The key to sort the results. Could be one of: name, provider and country.
     *     Defaults to name if not specified.
     * @param string $provider If specified, return banks whose 'provider' matches the given provider
     *     (case insensitive).
     * @return GetBanksResponse
     */
    public function getBanks($ids = null,
                             $search = null,
                             $country = null,
                             $page = null,
                             $perPage = null,
                             $sort = null,
                             $provider = null)
    {
        $unauthenticatedClient = ClientFactory::unauthenticated($this->channel);
        return $unauthenticatedClient->getBanks($ids, $search, $country, $page, $perPage, $sort, $provider);
    }

    /**
     * Returns a list of token enabled banks.
     *
     * @param string[] $ids If specified, return banks whose 'id' matches any one of the given ids
     *     (case-insensitive). Can be at most 1000.
     * @param int $page Result page to retrieve. Default to 1 if not specified.
     * @param int $perPage Maximum number of records per page. Can be at most 200. Default to 200
     *     if not specified.
     * @return GetBanksResponse
     */
    public function getBanksByIds($ids, $page, $perPage)
    {
        return $this->getBanks($ids, null, null, $page, $perPage, null, null);
    }

    /**
     * Returns a list of token enabled banks.
     *
     * @param string $search If specified, return banks whose 'name' or 'identifier' contains the given
     *     search string (case-insensitive)
     * @param string $country If specified, return banks whose 'country' matches the given ISO 3166-1
     *     alpha-2 country code (case-insensitive)
     * @param int $page Result page to retrieve. Default to 1 if not specified.
     * @param int $perPage Maximum number of records per page. Can be at most 200. Default to 200
     *     if not specified.
     * @param string $sort The key to sort the results. Could be one of: name, provider and country.
     *     Defaults to name if not specified.
     * @return GetBanksResponse
     */
    public function searchBanks($search, $country, $page, $perPage, $sort)
    {
        return $this->getBanks(null, $search, $country, $page, $perPage, $sort, null);
    }

    /**
     * Returns a list of token enabled banks.
     *
     * @param string $search If specified, return banks whose 'name' or 'identifier' contains the given
     *     search string (case-insensitive)
     * @param string $country If specified, return banks whose 'country' matches the given ISO 3166-1
     *     alpha-2 country code (case-insensitive)
     * @param int $page Result page to retrieve. Default to 1 if not specified.
     * @param int $perPage Maximum number of records per page. Can be at most 200. Default to 200
     *     if not specified.
     * @param string $sort The key to sort the results. Could be one of: name, provider and country.
     *     Defaults to name if not specified.
     * @param string $provider If specified, return banks whose 'provider' matches the given provider
     *     (case insensitive).
     * @return GetBanksResponse
     */
    public function searchBanksWithProvider($search, $country, $page, $perPage, $sort, $provider)
    {
        return $this->getBanks(null, $search, $country, $page, $perPage, $sort, $provider);
    }

    /**
     * Generates a Token request URL from a request ID, an original state and a CSRF token.
     *
     * @param string $requestId the request id
     * @param string $state the state
     * @param string $csrfToken the csrf token
     * @return string the token request url
     */
    public function generateTokenRequestUrl($requestId, $state = '', $csrfToken = '')
    {
        $csrfTokenHash = Util::hashString($csrfToken);
        $tokenRequestState = new TokenRequestState($csrfTokenHash, $state);

        return sprintf(
            self::TOKEN_REQUEST_TEMPLATE,
            $this->tokenCluster->getWebUrl(),
            $requestId,
            urlencode($tokenRequestState->serialize())
        );
    }

    /**
     * Get the token request result based on a token's tokenRequestId.
     *
     * @param string tokenRequestId the token request id
     * @return TokenRequestResult the token request result
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

    /**
     * Begins account recovery.
     *
     * @param Alias $alias the alias used to recover
     * @return string verification id
     */
    public function beginRecovery($alias)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->beginRecovery($alias);
    }

    /**
     * Gets recovery authorization from Token.
     *
     * @param string $verificationId the verification id
     * @param string $code the code
     * @param Key $privilegedKey the privileged key
     * @return MemberRecoveryOperation the recovery entry
     * @throws VerificationException if the code verification fails
     */
    public function getRecoveryAuthorization($verificationId, $code, $privilegedKey)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->getRecoveryAuthorization($verificationId, $code, $privilegedKey);
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
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $updatedMember = $unauthenticated->completeRecovery($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine);
        return new Member(ClientFactory::authenticated($this->channel, $updatedMember->getId(), $cryptoEngine));
    }

    /**
     * Completes account recovery if the default recovery rule was set.
     *
     * @param string $memberId the member id
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return Member the new member
     */
    public function completeRecoveryWithDefaultRule($memberId, $verificationId, $code)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $cryptoEngine = new TokenCryptoEngine($memberId, new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/'));
        $recoveredMember = $unauthenticated->completeRecoveryWithDefaultRule($memberId, $verificationId, $code, $cryptoEngine);
        $client = ClientFactory::authenticated($this->channel, $recoveredMember->getId(), $cryptoEngine);

        return new Member($client);
    }

    /**
     * Parse the token request callback URL to extract the state and the token ID. Verify that the
     * state contains the CSRF token hash and that the signature on the state and CSRF token is
     * valid.
     *
     * @param string $callbackUrl the token request callback url
     * @param string $csrfToken the csrf token
     * @return TokenRequestCallback object containing the token id and the original state
     * @throws Exception
     */
    public function parseTokenRequestCallbackUrl($callbackUrl, $csrfToken = null)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        $member = $client->getTokenMember();
        $parameters = TokenRequestCallbackParameters::create($callbackUrl);
        $state = TokenRequestState::parse($parameters->getSerializedState());

        if ($state->getCsrfTokenHash() != Util::hashString($csrfToken)) {
            throw new InvalidStateException($csrfToken);
        }

        $payload = new TokenRequestStatePayload();
        $payload->setTokenId($parameters->getTokenId());
        $payload->setState(urlencode($parameters->getSerializedState()));
        Util::verifySignature($member, $payload, $parameters->getSignature());

        return new TokenRequestCallback($parameters->getTokenId(), $state->getInnerState());
    }

}
