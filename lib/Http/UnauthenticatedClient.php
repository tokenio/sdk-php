<?php

namespace Tokenio\Http;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Alias\VerificationStatus;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberAddKeyOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\MemberUpdate;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenRequest;
use Io\Token\Proto\Common\Transaction\RequestStatus;
use Io\Token\Proto\Gateway\BeginRecoveryRequest;
use Io\Token\Proto\Gateway\BeginRecoveryResponse;
use Io\Token\Proto\Gateway\CompleteRecoveryRequest;
use Io\Token\Proto\Gateway\CompleteRecoveryResponse;
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
use Tokenio\Exception\VerificationException;
use Tokenio\Http\Request\TokenRequestResult;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Security\SignerInterface;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

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

    /**
     * Begins account recovery.
     *
     * @param Alias $alias the alias used to recover
     * @return string verification id
     */
    public function beginRecovery($alias)
    {
        $request = new BeginRecoveryRequest();
        $request->setAlias(Util::normalizeAlias($alias));
        /** @var BeginRecoveryResponse $response */
        list($response, $status) = $this->gateway->BeginRecovery($request)->wait();
        return $response->getVerificationId();
    }

    /**
     * Completes account recovery if the default recovery rule was set.
     *
     * @param string $memberId the member id
     * @param string $verificationId the verification id
     * @param string $code the code
     * @param CryptoEngineInterface $cryptoEngine
     * @return Member the new member
     */
    public function completeRecoveryWithDefaultRule($memberId, $verificationId, $code, $cryptoEngine)
    {
        $privelegedKey = $cryptoEngine->generateKey(Level::PRIVILEGED);
        $standardKey = $cryptoEngine->generateKey(Level::STANDARD);
        $lowKey = $cryptoEngine->generateKey(Level::LOW);

        $signer = $cryptoEngine->createSigner(Level::PRIVILEGED);

        $request = new CompleteRecoveryRequest();
        $request->setVerificationId($verificationId)
                ->setCode($code)
                ->setKey($privelegedKey);

        /** @var CompleteRecoveryResponse $response */
        list($completeResponse) = $this->gateway->CompleteRecovery($request)->wait();
        $memberRequest = new GetMemberRequest();
        $memberRequest->setMemberId($memberId);
        /** @var GetMemberResponse $memberResponse */
        list($memberResponse) = $this->gateway->GetMember($memberRequest)->wait();

        $memberRecoveryOperation = new MemberOperation();
        $memberRecoveryOperation->setRecover($completeResponse->getRecoveryEntry());

        $operations = Util::createMemberOperationsFromKeys([$privelegedKey, $standardKey, $lowKey]);
        $operations[] = $memberRecoveryOperation;
        $memberUpdate = new MemberUpdate();
        $memberUpdate->setMemberId($memberId)
                     ->setPrevHash($memberResponse->getMember()->getLastHash())
                     ->setOperations($operations);

        $signature = new Signature();
        $signature->setKeyId($signer->getKeyId())
                  ->setMemberId($memberId)
                  ->setSignature($signer->sign($memberUpdate));
        $updateMemberRequest = new UpdateMemberRequest();
        $updateMemberRequest->setUpdate($memberUpdate)
                            ->setUpdateSignature($signature);
        /** @var UpdateMemberResponse $memberUpdateResponse */
        list($memberUpdateResponse) = $this->gateway->UpdateMember($updateMemberRequest)->wait();
        return $memberUpdateResponse->getMember();
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
        $request = new CompleteRecoveryRequest();
        $request->setVerificationId($verificationId)
                ->setCode($code)
                ->setKey($privilegedKey);

        /** @var CompleteRecoveryResponse $response */
        list($response) = $this->gateway->CompleteRecovery($request)->wait();
        if($response->getStatus() !== VerificationStatus::SUCCESS){
            throw new VerificationException($response->getStatus());
        }
        return $response->getRecoveryEntry();
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
        $standardKey = $cryptoEngine->generateKey(Level::STANDARD);
        $lowKey = $cryptoEngine->generateKey(Level::LOW);
        $signer = $cryptoEngine->createSigner(Level::PRIVILEGED);
        $operations = array();
        foreach ($recoveryOperations as $op){
            $memberOperation = new MemberOperation();
            $memberOperation->setRecover($op);

            $operations[] = $memberOperation;
        }
        $operations = Util::createMemberOperationsFromKeys([$privilegedKey, $standardKey, $lowKey]);
        $getMemberRequest = new GetMemberRequest();
        $getMemberRequest->setMemberId($memberId);
        /** @var GetMemberResponse $getMemberResponse */
        list($getMemberResponse) = $this->gateway->GetMember($getMemberRequest)->wait();
        $memberUpdate = new MemberUpdate();
        $memberUpdate->setMemberId($memberId)
                     ->setPrevHash($getMemberResponse->getMember()->getLastHash())
                     ->setOperations($operations);
        echo $memberUpdate->serializeToJsonString();
        $updateSignature = new Signature();
        $updateSignature->setKeyId($signer->getKeyId())
                        ->setMemberId($memberId)
                        ->setSignature($signer->sign($memberUpdate));

        $memberUpdateRequest = new UpdateMemberRequest();
        $memberUpdateRequest->setUpdate($memberUpdate)
                            ->setUpdateSignature($updateSignature);
        /** @var UpdateMemberResponse $updateMemberResponse */
        list($updateMemberResponse, $status) = $this->gateway->UpdateMember($memberUpdateRequest)->wait();
        return $updateMemberResponse->getMember();
    }
}
