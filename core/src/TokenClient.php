<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Grpc\Channel;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Bank\BankFilter\BankFeatures;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Gateway\GetBanksResponse;
use Tokenio\Exception\VerificationException;
use Tokenio\Rpc\Client;
use Tokenio\Rpc\ClientFactory;
use Tokenio\Rpc\UnauthenticatedClient;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Util\Util;

class TokenClient
{
    /**
     * @var Channel
     */
    protected $channel;
    /**
     * @var TokenCluster
     */
    protected $tokenCluster;
    /**
     * @var CryptoEngineFactoryInterface
     */
    protected $cryptoEngineFactory;

    /**
     * Creates an instance of a Token SDK.
     *
     * @param Channel $channel the gRPC channel
     * @param TokenCluster $tokenCluster the token cluster to connect to
     * @param CryptoEngineFactoryInterface $cryptoEngineFactory the crypto factory to create crypto engine
     */
    public function __construct($channel, $cryptoEngineFactory, $tokenCluster)
    {
        $this->channel = $channel;
        $this->tokenCluster = $tokenCluster;
        $this->cryptoEngineFactory = $cryptoEngineFactory;
    }

    /**
     * Creates a new instance of {@link TokenClient} that's configured to use
     * the specified environment.
     *
     * @param TokenCluster $cluster token cluster to connect to
     * @param string $developerKey developer key
     * @return TokenClient instance
     * @throws \Exception
     */
    public static function create($cluster, $developerKey)
    {
        return TokenClient::builder()
            ->connectTo($cluster)
            ->developerKey($developerKey)
            ->build();
    }

    /**
     * @return TokenClientBuilder
     */
    public static function builder()
    {
        return new TokenClientBuilder();
    }

    /**
     * Resolves an alias to a TokenMember object, containing member ID and the alias
     * with the correct type
     *
     * @param Alias $alias to resolved
     * @return TokenMember resolved alias and member ID
     */
    public function resolveAlias($alias)
    {
        $client = ClientFactory::unauthenticated($this->channel);
        return $client->resolveAlias($alias);
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
     * be created with the member.
     * @param int $memberType the type of member to register
     * @param string $partnerId
     * @param string $recoveryAgent
     * @param string $realmId
     * @return Member
     * @throws \Exception
     */
    protected function createMemberImpl(
        $alias,
        $memberType,
        $partnerId = null,
        $recoveryAgent = null,
        $realmId = null)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $memberId = $unauthenticated->createMemberId($memberType, null, $partnerId, $realmId);
        return $this->setUpMemberImpl($alias, $memberId, $recoveryAgent);
    }

    /**
     * Sets up a member given a specific ID of a member that already exists in the system. If
     * the member ID already has keys, this will not succeed. Used for testing since this
     * gives more control over the member creation process.
     *
     * <p>Impl method returns incomplete member object that can be used for its instance
     * fields but will not be able to make calls.
     *
     * <p>Adds an alias and a set of auto-generated keys to the member.</p>
     *
     * @param alias nullable member alias to use, must be unique. If null, then no alias will
     *     be created with the member
     * @param string memberId member id
     * @param string agent member id of the primary recovery agent.
     * @return Member
     * @throws \Exception
     */
    protected function setUpMemberImpl(
        $alias,
        $memberId,
        $agent)
    {
        /** @var UnauthenticatedClient $unauthenticated */
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $agentId = $agent == null ? $unauthenticated->getDefaultAgent() : $agent;
        $crypto = $this->cryptoEngineFactory->create($memberId);

        $operations = array();
        $metadata = array();
        $operations[] = Util::toAddKeyOperation($crypto->generateKey(Key\Level::PRIVILEGED));
        $operations[] = Util::toAddKeyOperation($crypto->generateKey(Key\Level::STANDARD));
        $operations[] = Util::toAddKeyOperation($crypto->generateKey(Key\Level::LOW));
        $operations[] = Util::toRecoveryAgentOperation($agentId);

        if ($alias != null) {
            $operations[] = Util::toAddAliasOperation($alias);
            $metadata[] = Util::toAddAliasOperationMetadata($alias);
        }

        $signer = $crypto->createSigner(Key\Level::PRIVILEGED);
        $createdMember = $unauthenticated->createMember($memberId, $operations, $metadata, $signer);
        return new Member(
            $createdMember->getId(),
            $createdMember->getPartnerId(),
            $createdMember->getRealmId(),
            null,
            $this->tokenCluster);
    }

    /**
     * Return a Member set up to use some Token member's keys (assuming we have them).
     * Impl method returns incomplete member object that can be used for its instance
     * fields but will not be able to make calls.
     *
     * @param $memberId string member id
     * @param Client $client
     * @return Member
     * @throws \Exception
     */
    protected function getMemberImpl($memberId, $client)
    {
        $member = $client->getMember($memberId);
        return new Member(
            $member->getId(),
            $member->getPartnerId(),
            $member->getRealmId(),
            null,
            $this->tokenCluster
        );
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
    public function completeRecoveryImpl($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $updatedMember = $unauthenticated->completeRecovery($memberId, $recoveryOperations, $privilegedKey, $cryptoEngine);
        return new Member(
            $updatedMember->getId(),
            $updatedMember->getPartnerId(),
            $updatedMember->getRealmId(),
            null,
            $this->tokenCluster
        );
    }

    /**
     * Completes account recovery if the default recovery rule was set.
     *
     * @param string $memberId the member id
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return Member the new member
     */
    public function completeRecoveryWithDefaultRuleImpl($memberId, $verificationId, $code, $cryptoEngine)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        $recoveredMember = $unauthenticated->completeRecoveryWithDefaultRule($memberId, $verificationId, $code, $cryptoEngine);

        return new Member(
            $recoveredMember->getId(),
            $recoveredMember->getPartnerId(),
            $recoveredMember->getRealmId(),
            null,
            $this->tokenCluster
        );
    }

    /**
     * Begins account recovery.
     *
     * @param Alias $alias the alias used to recover
     * @return string verification id
     */
    public function beginRecovery($alias)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->beginRecovery($alias);
    }

    /**
     * Create a recovery authorization for some agent to sign.
     *
     * @param string $memberId Id of member we claim to be.
     * @param Key $privilegedKey new privileged key we want to use.
     * @return Authorization authorization structure for agent to sign
     */
    public function createRecoveryAuthorization($memberId, $privilegedKey)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->createRecoveryAuthorization($memberId, $privilegedKey);
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
     * Returns a list of token enabled banks.
     *
     * @param string[] $ids If specified, return banks whose 'id' matches any one of the given ids
     * (case-insensitive). Can be at most 1000.
     * @param string $search If specified, return banks whose 'name' or 'identifier' contains the given
     * search string (case-insensitive)
     * @param string $country If specified, return banks whose 'country' matches the given ISO 3166-1
     * alpha-2 country code (case-insensitive)
     * @param int $page Result page to retrieve. Default to 1 if not specified.
     * @param int $perPage Maximum number of records per page. Can be at most 200. Default to 200
     * if not specified.
     * @param string $sort The key to sort the results. Could be one of: name, provider and country.
     * Defaults to name if not specified.
     * @param string $provider If specified, return banks whose 'provider' matches the given provider
     * (case insensitive).
     * @param BankFeatures bankFeatures If specified, return banks who meet the bank features requirement.
     * @return GetBanksResponse
     */
    public function getBanks($ids = null,
                             $search = null,
                             $country = null,
                             $page = null,
                             $perPage = null,
                             $sort = null,
                             $provider = null,
                             $bankFeatures = null)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->getBanks($ids, $search, $country, $page, $perPage, $sort, $provider, $bankFeatures);
    }

    /**
     * Returns a list of countries with Token-enabled banks.
     *
     * @param string provider If specified, return banks whose 'provider' matches the given provider (case insensitive).
     * @return RepeatedField a list of country codes
     */
    public function getCountries($provider)
    {
        $unauthenticated = ClientFactory::unauthenticated($this->channel);
        return $unauthenticated->getCountries($provider);
    }
}