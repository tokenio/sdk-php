<?php

namespace Tokenio\Rpc;

use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Account\Account;
use Io\Token\Proto\Common\Address\Address;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Bank\BankInfo;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\AddressRecord;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberOperationMetadata;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\MemberUpdate;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Member\TrustedBeneficiary;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\RequestStatus;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Gateway\AddAddressRequest;
use Io\Token\Proto\Gateway\AddAddressResponse;
use Io\Token\Proto\Gateway\AddTrustedBeneficiaryRequest;
use Io\Token\Proto\Gateway\AddTrustedBeneficiaryResponse;
use Io\Token\Proto\Gateway\CancelTokenRequest;
use Io\Token\Proto\Gateway\CancelTokenResponse;
use Io\Token\Proto\Gateway\CreateAccessTokenRequest;
use Io\Token\Proto\Gateway\CreateAccessTokenResponse;
use Io\Token\Proto\Gateway\CreateBlobRequest;
use Io\Token\Proto\Gateway\CreateBlobResponse;
use Io\Token\Proto\Gateway\CreateTransferRequest;
use Io\Token\Proto\Gateway\CreateTransferResponse;
use Io\Token\Proto\Gateway\DeleteAddressRequest;
use Io\Token\Proto\Gateway\DeleteMemberRequest;
use Io\Token\Proto\Gateway\EndorseTokenRequest;
use Io\Token\Proto\Gateway\EndorseTokenResponse;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Proto\Gateway\GetAccountRequest;
use Io\Token\Proto\Gateway\GetAccountResponse;
use Io\Token\Proto\Gateway\GetAccountsRequest;
use Io\Token\Proto\Gateway\GetAccountsResponse;
use Io\Token\Proto\Gateway\GetActiveAccessTokenRequest;
use Io\Token\Proto\Gateway\GetActiveAccessTokenResponse;
use Io\Token\Proto\Gateway\GetAddressesRequest;
use Io\Token\Proto\Gateway\GetAddressesResponse;
use Io\Token\Proto\Gateway\GetAddressRequest;
use Io\Token\Proto\Gateway\GetAddressResponse;
use Io\Token\Proto\Gateway\GetAliasesRequest;
use Io\Token\Proto\Gateway\GetAliasesResponse;
use Io\Token\Proto\Gateway\GetBalanceRequest;
use Io\Token\Proto\Gateway\GetBalanceResponse;
use Io\Token\Proto\Gateway\GetBalancesRequest;
use Io\Token\Proto\Gateway\GetBalancesResponse;
use Io\Token\Proto\Gateway\GetBankInfoRequest;
use Io\Token\Proto\Gateway\GetBankInfoResponse;
use Io\Token\Proto\Gateway\GetBlobRequest;
use Io\Token\Proto\Gateway\GetBlobResponse;
use Io\Token\Proto\Gateway\GetDefaultAgentRequest;
use Io\Token\Proto\Gateway\GetDefaultAgentResponse;
use Io\Token\Proto\Gateway\GetMemberRequest;
use Io\Token\Proto\Gateway\GetMemberResponse;
use Io\Token\Proto\Gateway\GetProfilePictureRequest;
use Io\Token\Proto\Gateway\GetProfilePictureResponse;
use Io\Token\Proto\Gateway\GetProfileRequest;
use Io\Token\Proto\Gateway\GetProfileResponse;
use Io\Token\Proto\Gateway\GetTokenBlobRequest;
use Io\Token\Proto\Gateway\GetTokenBlobResponse;
use Io\Token\Proto\Gateway\GetTokenRequest;
use Io\Token\Proto\Gateway\GetTokenResponse;
use Io\Token\Proto\Gateway\GetTokensRequest;
use Io\Token\Proto\Gateway\GetTokensResponse;
use Io\Token\Proto\Gateway\GetTransactionRequest;
use Io\Token\Proto\Gateway\GetTransactionResponse;
use Io\Token\Proto\Gateway\GetTransactionsRequest;
use Io\Token\Proto\Gateway\GetTransactionsResponse;
use Io\Token\Proto\Gateway\GetTransferRequest;
use Io\Token\Proto\Gateway\GetTransferResponse;
use Io\Token\Proto\Gateway\GetTransfersRequest;
use Io\Token\Proto\Gateway\GetTransfersResponse;
use Io\Token\Proto\Gateway\GetTrustedBeneficiariesRequest;
use Io\Token\Proto\Gateway\GetTrustedBeneficiariesResponse;
use Io\Token\Proto\Gateway\Page;
use Io\Token\Proto\Gateway\RemoveTrustedBeneficiaryRequest;
use Io\Token\Proto\Gateway\RemoveTrustedBeneficiaryResponse;
use Io\Token\Proto\Gateway\RetryVerificationRequest;
use Io\Token\Proto\Gateway\RetryVerificationResponse;
use Io\Token\Proto\Gateway\SetProfilePictureRequest;
use Io\Token\Proto\Gateway\SetProfilePictureResponse;
use Io\Token\Proto\Gateway\SetProfileRequest;
use Io\Token\Proto\Gateway\SetProfileResponse;
use Io\Token\Proto\Gateway\SignTokenRequestStateRequest;
use Io\Token\Proto\Gateway\SignTokenRequestStateResponse;
use Io\Token\Proto\Gateway\StoreTokenRequestRequest;
use Io\Token\Proto\Gateway\StoreTokenRequestResponse;
use Io\Token\Proto\Gateway\UpdateMemberRequest;
use Io\Token\Proto\Gateway\UpdateMemberResponse;
use Io\Token\Proto\Gateway\VerifyAliasRequest;
use Io\Token\Proto\Gateway\VerifyAliasResponse;
use Tokenio\Exception;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\PagedList;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class Client
{
    /**
     * @var string
     */
    private $memberId;

    /**
     * @var CryptoEngineInterface
     */
    private $cryptoEngine;

    /**
     * @var GatewayServiceClient
     */
    private $gateway;

    private $customerInitiated = false;
    private $onBehalfOf;

    /**
     * Construct the Client.
     *
     * @param string $memberId the member id
     * @param CryptoEngineInterface $cryptoEngine the crypto engine used to sign for authentication, request payloads, etc
     * @param GatewayServiceClient $gateway the gateway gRPC client
     */
    public function __construct($memberId, $cryptoEngine, $gateway)
    {
        $this->memberId = $memberId;
        $this->cryptoEngine = $cryptoEngine;
        $this->gateway = $gateway;
    }

    /**
     * @return string
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @return CryptoEngineInterface
     */
    public function getCryptoEngine()
    {
        return $this->cryptoEngine;
    }

    /**
     * Returns a list of aliases of the member.
     *
     * @return RepeatedField
     */
    public function getAliases()
    {
        /** @var GetAliasesResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetAliases(new GetAliasesRequest()));
        return $response->getAliases();
    }

    /**
     * Looks up member information for the given member ID. The user is defined by
     * the key used for authentication.
     *
     * @param $memberId string member id
     * @return Member
     */
    public function getMember($memberId)
    {
        $request = new GetMemberRequest();
        $request->setMemberId($memberId);

        /** @var GetMemberResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetMember($request));
        return $response->getMember();
    }

    /**
     * Looks up a linked funding account.
     *
     * @param string $accountId the account id
     * @return Account the account info
     */
    public function getAccount($accountId)
    {
        $this->setOnBehalfOf();

        $request = new GetAccountRequest();
        $request->setAccountId($accountId);

        /** @var GetAccountResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetAccount($request));
        return $response->getAccount();
    }

    /**
     * Looks up all the linked funding accounts.
     *
     * @return RepeatedField a list of linked accounts
     */
    public function getAccounts()
    {
        $this->setOnBehalfOf();

        /** @var GetAccountsResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetAccounts(new GetAccountsRequest()));
        return $response->getAccounts();
    }

    /**
     * Updates member by applying the specified operations.
     *
     * @param Member $member to update
     * @param MemberOperation[] $operations operations to apply
     * @param MemberOperationMetadata[] metadata of operations
     * @return Member updated member
     */
    public function updateMember($member, $operations, $metadata = array())
    {
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);
        $memberUpdate = new MemberUpdate();
        $memberUpdate->setMemberId($member->getId())
            ->setPrevHash($member->getLastHash())
            ->setOperations($operations);

        $signature = new Signature();
        $signature->setMemberId($this->getMemberId())
            ->setKeyId($signer->getKeyId())
            ->setSignature($signer->sign($memberUpdate));

        $request = new UpdateMemberRequest();
        $request->setUpdate($memberUpdate)
            ->setUpdateSignature($signature)
            ->setMetadata($metadata);

        /** @var UpdateMemberResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->UpdateMember($request));
        return $response->getMember();
    }

    /**
     * Look up account balance.
     *
     * @param string $accountId the account id
     * @param int $keyLevel the key level
     * @return Balance
     * @throws Exception
     */
    public function getBalance($accountId, $keyLevel)
    {
        $this->setOnBehalfOf();
        $this->setRequestSignerKeyLevel($keyLevel);

        $request = new GetBalanceRequest();
        $request->setAccountId($accountId);

        /** @var GetBalanceResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetBalance($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return $response->getBalance();
        } else {
            throw new Exception\StepUpRequiredException('Balance step up required.');
        }
    }

    /**
     * Look up balances for a list of accounts.
     *
     * @param string[] $accountIds a list of account ids
     * @param int $keyLevel the key level
     * @return Balance[]
     */
    public function getBalances($accountIds, $keyLevel)
    {
        $this->setOnBehalfOf();
        $this->setRequestSignerKeyLevel($keyLevel);

        $request = new GetBalancesRequest();
        $request->setAccountId($accountIds);

        /** @var GetBalancesResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetBalances($request));

        $result = [];
        foreach ($response->getResponse() as $balance) {
            if ($balance->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
                $result[] = $balance->getBalance();
            }
        }

        return $result;
    }

    /**
     * Look up an existing transaction and return the response.
     *
     * @param string $accountId the account id
     * @param string $transactionId the transaction id
     * @param int $keyLevel the key level
     * @return Transaction
     * @throws Exception
     */
    public function getTransaction($accountId, $transactionId, $keyLevel)
    {
        $this->setOnBehalfOf();
        $this->setRequestSignerKeyLevel($keyLevel);

        $request = new GetTransactionRequest();
        $request->setAccountId($accountId)
            ->setTransactionId($transactionId);

        /** @var GetTransactionResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTransaction($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return $response->getTransaction();
        } else {
            throw new Exception\StepUpRequiredException('Transaction step up required.');
        }
    }

    /**
     * Lookup transactions and return response.
     *
     * @param string $accountId the account id
     * @param string $offset the offset
     * @param int $limit the limit
     * @param int $keyLevel the key level
     * @return PagedList list of transactions
     * @throws Exception
     */
    public function getTransactions($accountId, $offset, $limit, $keyLevel)
    {
        $this->setOnBehalfOf();
        $this->setRequestSignerKeyLevel($keyLevel);

        $request = new GetTransactionsRequest();
        $request->setAccountId($accountId);
        $request->setPage($this->pageBuilder($limit, $offset));

        /** @var GetTransactionsResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTransactions($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return new PagedList($response->getTransactions(), $response->getOffset());
        } else {
            throw new Exception\StepUpRequiredException('Transactions step up required.');
        }
    }

    /**
     * Looks up a existing token.
     *
     * @param $tokenId string token id
     * @return Token token returned by the server
     */
    public function getToken($tokenId)
    {
        $request = new GetTokenRequest();
        $request->setTokenId($tokenId);

        /** @var GetTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetToken($request));
        return $response->getToken();
    }

    /**
     * Looks up a existing access token where the calling member is the granter and given member is
     * the grantee.
     *
     * @param $toMemberId string beneficiary of the active access token
     * @return Token token returned by the server
     */
    public function getActiveAccessToken($toMemberId)
    {
        $request = new GetActiveAccessTokenRequest();
        $request->setToMemberId($toMemberId);

        /** @var GetActiveAccessTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetActiveAccessToken($request));
        return $response->getToken();
    }

    private function pageBuilder($limit, $offset = null)
    {
        $page = new Page();
        $page->setLimit($limit);

        if (!Strings::isEmptyString($offset)) {
            $page->setOffset($offset);
        }

        return $page;
    }

    private function setOnBehalfOf()
    {
        if ($this->onBehalfOf != null) {
            AuthenticationContext::setOnBehalfOf($this->onBehalfOf);
            AuthenticationContext::setCustomerInitiated($this->customerInitiated);
        }
    }

    private function setRequestSignerKeyLevel($keyLevel)
    {
        AuthenticationContext::setKeyLevel($keyLevel);
    }

    /**
     * Sets the On-Behalf-Of authentication value to be used
     * with this client.  The value must correspond to an existing
     * Access Token ID issued for the client member. Uses the given customer
     * initiated flag.
     *
     * @param string $accessTokenId the access token id to be used
     * @param bool $customerInitiated whether the customer initiated the calls
     */
    public function useAccessToken($accessTokenId, $customerInitiated = false)
    {
        $this->onBehalfOf = $accessTokenId;
        $this->customerInitiated = $customerInitiated;
    }

    public function clearAccessToken()
    {
        $this->onBehalfOf = null;
        $this->customerInitiated = false;
    }

    /**
     * Stores a transfer token request.
     *
     * @param TokenPayload $payload transfer token payload
     * @param MapField $options map of options
     * @param string $userRefId (optional) user ref id
     * @return string id to reference token request
     */
    public function storeTokenRequest($payload, $options, $userRefId = '')
    {
        $request = new StoreTokenRequestRequest();
        $request->setPayload($payload)
            ->setOptions($options)
            ->setUserRefId($userRefId);

        /** @var StoreTokenRequestResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->StoreTokenRequest($request));
        return $response->getTokenRequest()->getId();
    }

    /**
     * Creates and uploads a blob.
     *
     * @param Payload $payload the blob payload
     * @return string
     */
    public function createBlob($payload)
    {
        $request = new CreateBlobRequest();
        $request->setPayload($payload);

        /** @var CreateBlobResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->CreateBlob($request));
        return $response->getBlobId();
    }

    /**
     * Looks up an existing transfer.
     *
     * @param string $transferId transfer id
     * @return Transfer record
     */
    public function getTransfer($transferId)
    {
        $request = new GetTransferRequest();
        $request->setTransferId($transferId);

        /** @var GetTransferResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTransfer($request));
        return $response->getTransfer();
    }

    /**
     * Looks up a list of existing transfers.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param string $tokenId optional token id to restrict the search
     * @return PagedList containing transfer records
     */
    public function getTransfers($limit, $offset = null, $tokenId = null)
    {
        $request = new GetTransfersRequest();
        $request->setPage($this->pageBuilder($limit, $offset));
        if($tokenId !== null){
            $filter = new GetTransfersRequest\TransferFilter();
            $filter->setTokenId($tokenId);
            $request->setFilter($filter);
        }
        /** @var GetTransfersResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTransfers($request));
        return new PagedList($response->getTransfers(), $response->getOffset());
    }

    /**
     * Redeems a transfer token.
     *
     * @param TransferPayload $payload the transfer payload
     * @return Transfer
     */
    public function createTransfer($payload)
    {
        $signer = $this->cryptoEngine->createSigner(Level::LOW);

        $payloadSignature = new Signature();
        $payloadSignature->setMemberId($this->getMemberId());
        $payloadSignature->setKeyId($signer->getKeyId());
        $payloadSignature->setSignature($signer->sign($payload));

        $request = new CreateTransferRequest();
        $request->setPayload($payload);
        $request->setPayloadSignature($payloadSignature);

        /** @var CreateTransferResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->CreateTransfer($request));
        return $response->getTransfer();
    }

    /**
     * Cancels a token.
     *
     * @param Token $token to cancel
     * @return TokenOperationResult result of the cancel operation, returned by the server
     */
    public function cancelToken($token)
    {
        $signer = $this->cryptoEngine->createSigner(Level::LOW);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
                  ->setKeyId($signer->getKeyId())
                  ->setSignature($signer->signString($this->tokenActionFromToken($token, 'CANCELLED')));

        $request = new CancelTokenRequest();
        $request->setTokenId($token->getId())
                ->setSignature($signature);

        /** @var CancelTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->CancelToken($request));
        return $response->getResult();
    }
    /**
     * @param Token $token
     * @param string $action
     * @return string
     */
    private function tokenActionFromToken($token, $action)
    {
        return $this->tokenAction($token->getPayload(), $action);
    }

    /**
     * @param TokenPayload $payload
     * @param string $action
     * @return string
     */
    private function tokenAction($payload, $action)
    {
        return sprintf('%s.%s', Util::toJson($payload), strtolower($action));
    }

    /**
     * Sign with a Token signature a token request state payload.
     *
     * @param string $tokenRequestId token request id
     * @param string $tokenId token id
     * @param string $state state
     * @return Signature
     */
    public function signTokenRequestState($tokenRequestId, $tokenId, $state)
    {
        $request = new SignTokenRequestStateRequest();
        $requestState = new TokenRequestStatePayload();
        $requestState->setTokenId($tokenId)
                     ->setState($state);

        $request->setPayload($requestState)
                ->setTokenRequestId($tokenRequestId);

        /** @var SignTokenRequestStateResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->SignTokenRequestState($request));
        return $response->getSignature();
    }

    /**
    * Delete the member.
    *
    * @return bool
    */
    public function deleteMember()
    {
        $this->setOnBehalfOf();
        $this->setRequestSignerKeyLevel(Level::PRIVILEGED);
        /** @var DeleteMemberRequest $response */
        $response = Util::executeAndHandleCall($this->gateway->DeleteMember(new DeleteMemberRequest()));
        return $response !== null;
    }

    /**
     * Replaces a member's public profile.
     *
     * @param Profile $profile to set
     * @return Profile which is set
     */
    public function setProfile($profile)
    {
        $request = new SetProfileRequest();
        $request->setProfile($profile);
        /** @var SetProfileResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->SetProfile($request));
        return $response->getProfile();
    }

    /**
     * Gets a member's public profile.
     *
     * @param string $memberId member Id whose profile we want
     * @return Profile
     */
    public function getProfile($memberId)
    {
        $request = new GetProfileRequest();
        $request->setMemberId($memberId);

        /** @var GetProfileResponse $response */
        list($response) = $this->gateway->GetProfile($request)->wait();
        return $response->getProfile();
    }

    /**
     * Replaces a member's public profile picture.
     *
     * @param Payload $payload Picture data
     * @return bool that completes when request handled
     */
    public function setProfilePicture($payload)
    {
        $request = new SetProfilePictureRequest();
        $request->setPayload($payload);

        /** @var SetProfilePictureResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->SetProfilePicture($request));
        return $response !== null;
    }

    /**
     * Gets a member's public profile picture.
     *
     * @param string $memberId member Id whose profile we want
     * @param int $size ProfilePictureSize size category we want (small, medium, large, original)
     * @return Blob with picture; empty blob (no fields set) if has no picture
     */
    public function getProfilePicture($memberId, $size)
    {
        $request = new GetProfilePictureRequest();
        $request->setMemberId($memberId)
                ->setSize($size);

        /** @var GetProfilePictureResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetProfilePicture($request));
        return $response->getBlob();
    }

    /**
     * Verifies a given alias.
     *
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return bool if operation succeed
     */
    public function verifyAlias($verificationId, $code)
    {
        $request = new VerifyAliasRequest();
        $request->setCode($code)
                ->setVerificationId($verificationId);

        /** @var VerifyAliasResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->VerifyAlias($request));
        return $response !== null;
    }

    /**
     * Retry alias verification.
     *
     * @param Alias $alias the alias to be verified
     * @return string $verificationId
     */
    public function retryVerification($alias)
    {
        $request = new RetryVerificationRequest();
        $request->setAlias($alias)
                ->setMemberId($this->getMemberId());

        /** @var RetryVerificationResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->RetryVerification($request));
        return $response->getVerificationId();
    }

    /**
     * Set Token as the recovery agent.
     */
    public function useDefaultRecoveryRule()
    {
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);
        $member = $this->getMember($this->getMemberId());
        /** @var GetDefaultAgentResponse $defAgentResponse */
        $defAgentResponse = Util::executeAndHandleCall($this->gateway->GetDefaultAgent(new GetDefaultAgentRequest()));
        $rule = new RecoveryRule();
        $rule->setPrimaryAgent($defAgentResponse->getMemberId());

        $recoveryRuleOperation = new MemberRecoveryRulesOperation();
        $recoveryRuleOperation->setRecoveryRule($rule);

        $operation = new MemberOperation();
        $operation->setRecoveryRules($recoveryRuleOperation);

        $memberUpdate = new MemberUpdate();
        $memberUpdate->setPrevHash($member->getLastHash())
                     ->setMemberId($member->getId())
                     ->setOperations([$operation]);

        $signature = new Signature();
        $signature->setKeyId($signer->getKeyId())
                  ->setMemberId($member->getId())
                  ->setSignature($signer->sign($memberUpdate));

        $request = new UpdateMemberRequest();
        $request->setUpdate($memberUpdate)
                ->setUpdateSignature($signature);

        Util::executeAndHandleCall($this->gateway->UpdateMember($request));
    }

    /**
     * Gets the member id of the default recovery agent.
     *
     * @return string the member id
     */
    public function getDefaultAgent()
    {
        /** @var GetDefaultAgentResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetDefaultAgent(new GetDefaultAgentRequest()));
        return $response->getMemberId();
    }

    /**
     * Authorizes recovery as a trusted agent.
     *
     * @param Authorization $authorization the authorization
     * @return Signature
     */
    public function authorizeRecovery($authorization)
    {
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);
        $signature = new Signature();
        $signature->setMemberId($this->getMemberId())
                  ->setKeyId($signer->getKeyId())
                  ->setSignature($signer->sign($authorization));

        return $signature;
    }

    /**
     * Retrieves a blob from the server.
     *
     * @param string $blobId id of the blob
     * @return Blob
     */
    public function getBlob($blobId)
    {
        $request = new GetBlobRequest();
        $request->setBlobId($blobId);
        /** @var GetBlobResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetBlob($request));
        return $response != null ? $response->getBlob() : null;
    }

    /**
     * Retrieves a blob that is attached to a token.
     *
     * @param string $tokenId id of the token
     * @param string $blobId id of the blob
     * @return Blob
     */
    public function getTokenBlob($tokenId, $blobId)
    {
        $request = new GetTokenBlobRequest();
        $request->setTokenId($tokenId)
                ->setBlobId($blobId);
        /** @var GetTokenBlobResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTokenBlob($request));
        return $response->getBlob();

    }

    /**
     * Creates a new member address.
     *
     * @param string $name the name of the address
     * @param Address $address the address
     * @return AddressRecord record created
     */
    public function addAddress($name, $address)
    {
        $signer = $this->cryptoEngine->createSigner(Level::LOW);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
                  ->setKeyId($signer->getKeyId())
                  ->setSignature($signer->sign($address));

        $request = new AddAddressRequest();
        $request->setName($name)
                ->setAddress($address)
                ->setAddressSignature($signature);

        /** @var AddAddressResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->AddAddress($request));
        return $response->getAddress();
    }

    /**
     * Looks up an address by id.
     *
     * @param string $addressId the address id
     * @return AddressRecord
     */
    public function getAddress($addressId)
    {
        $request = new GetAddressRequest();
        $request->setAddressId($addressId);
        /** @var GetAddressResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetAddress($request));
        return $response !== null ? $response->getAddress() : null;
    }

    /**
     * Looks up member addresses.
     *
     * @return RepeatedField a list of addresses
     */
    public function getAddresses()
    {
        $request = new GetAddressesRequest();
        /** @var GetAddressesResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetAddresses($request));
        return $response->getAddresses();
    }

    /**
     * Deletes a member address by its id.
     *
     * @param string $addressId the id of the address
     * @return bool that indicates whether the operation finished or had an error
     */
    public function deleteAddress($addressId)
    {
        $request = new DeleteAddressRequest();
        $request->setAddressId($addressId);
        /** @var DeleteAddressRequest $response */
        $response = Util::executeAndHandleCall($this->gateway->DeleteAddress($request));
        return $response !== null;
    }


    /**
     * Returns linking information for the specified bank id.
     *
     * @param string $bankId the bank id
     * @return BankInfo linking information
     */
    public function getBankInfo($bankId)
    {
        $request = new GetBankInfoRequest();
        $request->setBankId($bankId);
        /** @var GetBankInfoResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetBankInfo($request));
        return $response->getInfo();
    }

    /**
     * Adds a trusted beneficiary for whom the SCA will be skipped.
     *
     * @param TrustedBeneficiary\Payload the payload of the request
     * @return bool
     */
    public function addTrustedBeneficiary($payload)
    {
        $signer = $this->cryptoEngine->createSigner(Level::STANDARD);
        $request = new AddTrustedBeneficiaryRequest();
        $signature = new Signature();
        $signature->setKeyId($signer->getKeyId())
                  ->setMemberId($this->memberId)
                  ->setSignature($signer->sign($payload));
        $trustedBenificiary = new TrustedBeneficiary();
        $trustedBenificiary->setPayload($payload)
                           ->setSignature($signature);
        $request->setTrustedBeneficiary($trustedBenificiary);
        /** @var AddTrustedBeneficiaryResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->AddTrustedBeneficiary($request));
        return $response !== null;
    }

    /**
     * Removes a trusted beneficiary.
     *
     * @param TrustedBeneficiary\Payload the payload of the request
     * @return bool
     */
    public function removeTrustedBeneficiary($payload)
    {
        $signer = $this->cryptoEngine->createSigner(Level::STANDARD);
        $signature = new Signature();
        $signature->setKeyId($signer->getKeyId())
                  ->setMemberId($this->memberId)
                  ->setSignature($signer->sign($payload));
        $trustedBenificiary = new TrustedBeneficiary();
        $trustedBenificiary->setPayload($payload)
                           ->setSignature($signature);
        $request = new RemoveTrustedBeneficiaryRequest();
        $request->setTrustedBeneficiary($trustedBenificiary);
        /** @var RemoveTrustedBeneficiaryResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->RemoveTrustedBeneficiary($request));
        return $response !== null;
    }

    /**
     * Gets a list of all trusted beneficiaries.
     *
     * @return RepeatedField
     */
    public function getTrustedBeneficiaries()
    {
        $request = new GetTrustedBeneficiariesRequest();
        /** @var GetTrustedBeneficiariesResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTrustedBeneficiaries($request));
        return $response->getTrustedBeneficiaries();
    }

    /**
     * Creates a new access token.
     *
     * @param TokenPayload $payload transfer token payload
     * @return Token returned by the server
     */
    public function createAccessToken($payload)
    {
        $tokenMember = new TokenMember();
        $tokenMember->setId($this->getMemberId());
        $payload->setFrom($tokenMember);
        $request = new CreateAccessTokenRequest();
        $request->setPayload($payload);
        /** @var CreateAccessTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->CreateAccessToken($request));
        return $response->getToken();

    }

    /**
     * Creates a new access token.
     *
     * @param TokenPayload $tokenPayload token payload
     * @param string $tokenRequestId token request id
     * @return Token returned by server
     */
    public function createAccessTokenForTokenRequestId($tokenPayload, $tokenRequestId)
    {
        $request = new CreateAccessTokenRequest();
        $request->setPayload($tokenPayload)
                ->setTokenRequestId($tokenRequestId);

        /** @var CreateAccessTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->CreateAccessToken($request));
        return $response->getToken();
    }

    /**
     * Endorses the token by signing it. The signature is persisted along
     * with the token.
     *
     * <p>If the key's level is too low, the result's status is MORE_SIGNATURES_NEEDED
     * and the system pushes a notification to the member prompting them to use a
     * higher-privilege key.
     *
     * @param Token $token to endorse
     * @param int $keyLevel key level to be used to endorse the token
     * @return TokenOperationResult result of endorse token
     */
    public function endorseToken($token, $keyLevel)
    {
        $signer = $this->cryptoEngine->createSigner($keyLevel);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
                  ->setKeyId($signer->getKeyId())
                  ->setSignature($signer->signString($this->tokenActionFromToken($token, 'ENDORSED')));
        $request = new EndorseTokenRequest();
        $request->setTokenId($token->getId())
                ->setSignature($signature);
        /** @var EndorseTokenResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->EndorseToken($request));
        return $response->getResult();
    }

    /**
     * Looks up a list of existing token.
     *
     * @param int $type token type
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @return PagedList returned by the server
     */
    public function getTokens($type, $offset, $limit)
    {
        $request = new GetTokensRequest();
        $request->setType($type)
                ->setPage($this->pageBuilder($limit, $offset));

        /** @var GetTokensResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTokens($request));
        return new PagedList($response->getTokens(), $offset);
    }
}
