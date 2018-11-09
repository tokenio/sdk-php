<?php

namespace Tokenio\Http;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberUpdate;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Gateway\CreateMemberRequest;
use Io\Token\Proto\Gateway\CreateMemberResponse;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Proto\Gateway\GetBanksRequest;
use Io\Token\Proto\Gateway\GetBanksResponse;
use Io\Token\Proto\Gateway\GetMemberRequest;
use Io\Token\Proto\Gateway\GetMemberResponse;
use Io\Token\Proto\Gateway\GetTokenRequestResultRequest;
use Io\Token\Proto\Gateway\GetTokenRequestResultResponse;
use Io\Token\Proto\Gateway\ResolveAliasRequest;
use Io\Token\Proto\Gateway\ResolveAliasResponse;
use Io\Token\Proto\Gateway\RetrieveTokenRequestRequest;
use Io\Token\Proto\Gateway\RetrieveTokenRequestResponse;
use Io\Token\Proto\Gateway\UpdateMemberRequest;
use Io\Token\Proto\Gateway\UpdateMemberResponse;
use Tokenio\Http\Request\TokenRequestResult;
use Tokenio\Security\SignerInterface;
use Tokenio\Util\Strings;

class UnauthenticatedClient
{
    /**
     * @var GatewayServiceClient
     */
    private $gateway;

    /**
     * Construct the UnauthenticatedClient.
     *
     * @param GatewayServiceClient $gateway the gateway gRPC client
     */
    public function __construct($gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Checks if a given alias already exists.
     *
     * @param Alias $alias the alias to check
     * @return bool {@code true} if alias already exists, {@code false} otherwise
     */
    public function aliasExists($alias)
    {
        return $this->resolveAlias($alias) != null;
    }

    private function resolveAlias($alias)
    {
        $request = new ResolveAliasRequest();
        $request->setAlias($alias);

        /** @var ResolveAliasResponse $response */
        list($response) = $this->gateway->ResolveAlias($request)->wait();
        return $response->getMember();
    }

    /**
     * Looks up member id for a given alias.
     *
     * @param Alias $alias the alias to check
     * @return string id, or null if member not found
     */
    public function getMemberId($alias)
    {
        $member = $this->resolveAlias($alias);

        if ($member != null) {
            return $member->getId();
        }

        return null;
    }

    /**
     * Looks up member information for the given member ID. The user is defined by
     * the key used for authentication.
     *
     * @param string $memberId the member id
     * @return Member
     */
    public function getMember($memberId)
    {
        $request = new GetMemberRequest();
        $request->setMemberId($memberId);

        /** @var GetMemberResponse $response */
        list($response) = $this->gateway->GetMember($request)->wait();
        return $response->getMember();
    }

    /**
     * Creates new member ID. After the method returns the ID is reserved on the server.
     *
     * @param int $memberType the type of member to register
     * @param $tokenRequestId (optional) token request id
     * @return string the created member ID
     */
    public function createMemberId($memberType, $tokenRequestId = null)
    {
        $request = new CreateMemberRequest();
        $request->setNonce(Strings::generateNonce());
        $request->setMemberType($memberType);

        if ($tokenRequestId != null) {
            $request->setTokenRequestId($tokenRequestId);
        }

        /** @var CreateMemberResponse $response */
        list($response) = $this->gateway->CreateMember($request)->wait();
        return $response->getMemberId();
    }

    /**
     * Creates a new token member.
     *
     * @param $memberId string member ID
     * @param $operations MemberOperation[] to set up member keys and aliases
     * @param $metadata [] of operations
     * @param $signer SignerInterface used to sign the requests
     * @return member information
     */
    public function createMember($memberId, $operations, $metadata, $signer)
    {
        $update = new MemberUpdate();
        $update->setMemberId($memberId)
               ->setOperations($operations);

        $signature = new Signature();
        $signature->setMemberId($memberId)
                  ->setKeyId($signer->getKeyId())
                  ->setSignature($signer->sign($update));

        $request = new UpdateMemberRequest();
        $request->setUpdate($update)
                ->setUpdateSignature($signature)
                ->setMetadata($metadata);

        /** @var UpdateMemberResponse $response */
        list($response) = $this->gateway->UpdateMember($request)->wait();
        return $response->getMember();
    }

    /**
     * Return the token member.
     *
     * @return Member
     */
    public function getTokenMember()
    {
        $alias = new Alias();
        $alias->setType(Alias\Type::DOMAIN)
            ->setValue('token.io')
            ->setRealm('token');

        $memberId = $this->getMemberId($alias);
        if ($memberId == null) {
            return null;
        }

        return $this->getMember($memberId);
    }

    /**
     * Returns a list of token enabled banks.
     *
     * @param array $ids If specified, return banks whose 'id' matches any one of the given ids
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
     * @return GetBanksResponse the list of banks
     */
    public function getBanks($ids = [], $search = null, $country = null, $page = null, $perPage = null, $sort = null, $provider = null)
    {
        $request = new GetBanksRequest();

        if (!empty($ids)) {
            $request->setIds($ids);
        }

        if (isset($search)) {
            $request->setSearch($search);
        }

        if (isset($country)) {
            $request->setCountry($country);
        }

        if (isset($page)) {
            $request->setPage($page);
        }

        if (isset($perPage)) {
            $request->setPerPage($perPage);
        }

        if (isset($sort)) {
            $request->setSort($sort);
        }

        if (isset($provider)) {
            $request->setProvider($provider);
        }

        /** @var GetBanksResponse $response */
        list($response) = $this->gateway->GetBanks($request)->wait();
        return $response;
    }

    /**
     * Retrieves a transfer token request.
     *
     * @param string $tokenRequestId the token request id
     *
     * @return TokenRequest the token request that was stored with the request id
     */
    public function retrieveTokenRequest($tokenRequestId)
    {
        $request = new RetrieveTokenRequestRequest();
        $request->setRequestId($tokenRequestId);

        /** @var RetrieveTokenRequestResponse $response */
        list($response) = $this->gateway->RetrieveTokenRequest($request)->wait();
        return $response->getTokenRequest();
    }

    /**
     * Get the token request result based on a token's tokenRequestId.
     *
     * @param string $tokenRequestId the token request id
     * @return TokenRequestResult
     */
    public function getTokenRequestResult($tokenRequestId)
    {
        $request = new GetTokenRequestResultRequest();
        $request->setTokenRequestId($tokenRequestId);

        /** @var GetTokenRequestResultResponse $response */
        list($response) = $this->gateway->GetTokenRequestResult($request)->wait();
        return new TokenRequestResult($response->getTokenId(), $response->getSignature());
    }

    /**
     * Get the default recovery agent id.
     *
     * @return string default recovery agent id.
     */
    public function getDefaultAgent()
    {
        $request = new ResolveAliasRequest();
        $alias = new Alias();
        $alias->setType(Alias\Type::DOMAIN)
              ->setValue('token.io');

        $request->setAlias($alias);
        /** @var ResolveAliasResponse $response */
        list($response) = $this->gateway->ResolveAlias($request)->wait();
        return $response->getMember()->getId();
    }
}
