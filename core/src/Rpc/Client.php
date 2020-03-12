<?php

namespace Tokenio\Rpc;

use Google\Protobuf\Internal\RepeatedField;
use Grpc\Channel;
use Grpc\Interceptor;
use Grpc\Internal\InterceptorChannel;
use Io\Token\Proto\Banklink\AccountLinkingStatus;
use Io\Token\Proto\Banklink\OauthBankAuthorization;
use Io\Token\Proto\Common\Account\Account;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Bank\BankInfo;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberOperationMetadata;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\MemberUpdate;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\CustomerTrackingMetadata;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\RequestStatus;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Gateway\CreateTestBankAccountRequest;
use Io\Token\Proto\Gateway\CreateTestBankAccountResponse;
use Io\Token\Proto\Gateway\DeleteMemberRequest;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Proto\Gateway\GetAccountRequest;
use Io\Token\Proto\Gateway\GetAccountResponse;
use Io\Token\Proto\Gateway\GetAccountsRequest;
use Io\Token\Proto\Gateway\GetAccountsResponse;
use Io\Token\Proto\Gateway\GetAliasesRequest;
use Io\Token\Proto\Gateway\GetAliasesResponse;
use Io\Token\Proto\Gateway\GetBalanceRequest;
use Io\Token\Proto\Gateway\GetBalanceResponse;
use Io\Token\Proto\Gateway\GetBalancesRequest;
use Io\Token\Proto\Gateway\GetBalancesResponse;
use Io\Token\Proto\Gateway\GetBankInfoRequest;
use Io\Token\Proto\Gateway\GetBankInfoResponse;
use Io\Token\Proto\Gateway\GetDefaultAgentRequest;
use Io\Token\Proto\Gateway\GetDefaultAgentResponse;
use Io\Token\Proto\Gateway\GetMemberRequest;
use Io\Token\Proto\Gateway\GetMemberResponse;
use Io\Token\Proto\Gateway\GetProfilePictureRequest;
use Io\Token\Proto\Gateway\GetProfilePictureResponse;
use Io\Token\Proto\Gateway\GetProfileRequest;
use Io\Token\Proto\Gateway\GetProfileResponse;
use Io\Token\Proto\Gateway\GetTransactionRequest;
use Io\Token\Proto\Gateway\GetTransactionResponse;
use Io\Token\Proto\Gateway\GetTransactionsRequest;
use Io\Token\Proto\Gateway\GetTransactionsResponse;
use Io\Token\Proto\Gateway\LinkAccountsOauthRequest;
use Io\Token\Proto\Gateway\LinkAccountsOauthResponse;
use Io\Token\Proto\Gateway\Page;
use Io\Token\Proto\Gateway\ResolveTransferDestinationsRequest;
use Io\Token\Proto\Gateway\ResolveTransferDestinationsResponse;
use Io\Token\Proto\Gateway\RetryVerificationRequest;
use Io\Token\Proto\Gateway\RetryVerificationResponse;
use Io\Token\Proto\Gateway\UpdateMemberRequest;
use Io\Token\Proto\Gateway\UpdateMemberResponse;
use Io\Token\Proto\Gateway\VerifyAliasRequest;
use Io\Token\Proto\Gateway\VerifyAliasResponse;
use RuntimeException;
use Tokenio\Exception;
use Tokenio\PagedList;
use Tokenio\Rpc\Interceptor\ClientAuthenticatorInterceptor;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class Client
{
    /**
     * @var string
     */
    protected $memberId;

    /**
     * @var CryptoEngineInterface
     */
    protected $cryptoEngine;

    /**
     * @var Channel
     */
    protected $channel;

    protected $customerInitiated = false;
    protected $onBehalfOf;

    /**
     * @var CustomerTrackingMetadata
     */
    protected $customerTrackingMetadata;

    /**
     * Construct the Client.
     *
     * @param string $memberId the member id
     * @param CryptoEngineInterface $cryptoEngine the crypto engine used to sign for authentication, request payloads, etc
     * @param Channel $channel the RPC channel to use
     */
    public function __construct($memberId, $cryptoEngine, $channel)
    {
        $this->memberId = $memberId;
        $this->cryptoEngine = $cryptoEngine;
        $this->channel = $channel;
        $this->customerTrackingMetadata = new CustomerTrackingMetadata();
    }

    /**
     * Looks up member information for the given member ID. The user is defined by
     * the key used for authentication.
     *
     * @param $memberId string member id
     * @return Member
     * @throws \Exception
     */
    public function getMember($memberId= null)
    {
        $request = new GetMemberRequest();
        if($memberId !== null)
        {
            $request->setMemberId($memberId);
        }
        else{
            $request->setMemberId($this->memberId);
        }
        /** @var GetMemberResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetMember($request));
        return $response->getMember();
    }

    /**
     * Updates member by applying the specified operations.
     *
     * @param Member $member to update
     * @param MemberOperation[] $operations operations to apply
     * @param MemberOperationMetadata[] metadata of operations
     * @return Member updated member
     * @throws \Exception
     */
    public function updateMember($member, $operations, $metadata = array())
    {
        if (empty($operations)) {
            return $member;
        }
        if($member === null)
        {
            $member = $this->getMember();
        }
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);
        $memberUpdate = new MemberUpdate();
        $memberUpdate->setMemberId($member->getId())
            ->setPrevHash($member->getLastHash())
            ->setOperations($operations);

        $signature = new Signature();
        $signature->setMemberId($this->memberId)
            ->setKeyId($signer->getKeyId())
            ->setSignature($signer->sign($memberUpdate));

        $request = new UpdateMemberRequest();
        $request->setUpdate($memberUpdate)
            ->setUpdateSignature($signature)
            ->setMetadata($metadata);

        /** @var UpdateMemberResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->UpdateMember($request));
        return $response->getMember();
    }

    /**
     * Set Token as the recovery agent.
     * @throws \Exception
     */
    public function useDefaultRecoveryRule()
    {
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);
        $member = $this->getMember($this->memberId);

        /** @var GetDefaultAgentResponse $defAgentResponse */
        $defAgentResponse = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->GetDefaultAgent(new GetDefaultAgentRequest()));
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

        Util::executeAndHandleCall(self::gateway($this->authenticationContext())->UpdateMember($request));
    }

    /**
     * Gets a member's public profile.
     *
     * @param string $memberId member Id whose profile we want
     * @return Profile
     * @throws \Exception
     */
    public function getProfile($memberId)
    {
        $request = new GetProfileRequest();
        $request->setMemberId($memberId);

        /** @var GetProfileResponse $response */
        list($response) = self::gateway($this->authenticationContext())->GetProfile($request)->wait();
        return $response->getProfile();
    }

    /**
     * Gets a member's public profile picture.
     *
     * @param string $memberId member Id whose profile we want
     * @param int $size ProfilePictureSize size category we want (small, medium, large, original)
     * @return Blob with picture; empty blob (no fields set) if has no picture
     * @throws \Exception
     */
    public function getProfilePicture($memberId, $size)
    {
        $request = new GetProfilePictureRequest();
        $request->setMemberId($memberId)
            ->setSize($size);

        /** @var GetProfilePictureResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->GetProfilePicture($request));
        return $response->getBlob();
    }

    /**
     * @param TokenPayload $payload
     * @param int $keyLevel
     * @return Signature
     */
    public function signTokenPayload($payload, $keyLevel)
    {
        $actio =$this->tokenAction($payload, "ENDORSED");
        $signer = $this->cryptoEngine->createSigner($keyLevel);
        $signature = new Signature();
        $signature->setKeyId($signer->getKeyId())
            ->setMemberId($this->memberId)
            ->setSignature($signer->signString($actio));
        return $signature;
    }

    /**
     * Looks up a linked funding account.
     *
     * @param string $accountId the account id
     * @return Account the account info
     * @throws \Exception
     */
    public function getAccount($accountId)
    {
        $request = new GetAccountRequest();
        $request->setAccountId($accountId);

        /** @var GetAccountResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf())
            ->GetAccount($request));
        return $response->getAccount();
    }

    /**
     * Looks up all the linked funding accounts.
     *
     * @return RepeatedField a list of linked accounts
     * @throws \Exception
     */
    public function getAccounts()
    {
        $request = new GetAccountsRequest();
        /** @var GetAccountsResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf())
            ->GetAccounts($request));
        return $response->getAccounts();
    }

    /**
     * Look up account balance.
     *
     * @param string $accountId the account id
     * @param int $keyLevel the key level
     * @return Balance
     * @throws Exception\StepUpRequiredException
     * @throws Exception\RequestException
     * @throws \Exception
     */
    public function getBalance($accountId, $keyLevel)
    {
        $request = new GetBalanceRequest();
        $request->setAccountId($accountId);

        /** @var GetBalanceResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf($keyLevel))
            ->GetBalance($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return $response->getBalance();
        } elseif ($response->getStatus() == RequestStatus::MORE_SIGNATURES_NEEDED) {
            throw new Exception\StepUpRequiredException('Balance step up required.');
        } else {
            throw new Exception\RequestException($response->getStatus());
        }
    }

    /**
     * Look up balances for a list of accounts.
     *
     * @param string[] $accountIds a list of account ids
     * @param int $keyLevel the key level
     * @return Balance[]
     * @throws Exception\RequestException
     * @throws Exception\StepUpRequiredException
     * @throws \Exception
     */
    public function getBalances($accountIds, $keyLevel)
    {
        $request = new GetBalancesRequest();
        $request->setAccountId($accountIds);

        /** @var GetBalancesResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf($keyLevel))
            ->GetBalances($request));

        $result = [];
        foreach ($response->getResponse() as $balance) {
            if ($balance->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
                $result[] = $balance->getBalance();
            } elseif ($balance->getStatus() == RequestStatus::MORE_SIGNATURES_NEEDED) {
                throw new Exception\StepUpRequiredException('Balance step up required.');
            } else {
                throw new Exception\RequestException($balance->getStatus());
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
     * @throws Exception\StepUpRequiredException
     * @throws Exception\RequestException
     * @throws \Exception
     */
    public function getTransaction($accountId, $transactionId, $keyLevel)
    {
        $request = new GetTransactionRequest();
        $request->setAccountId($accountId)
            ->setTransactionId($transactionId);

        /** @var GetTransactionResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf($keyLevel))
            ->GetTransaction($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return $response->getTransaction();
        } elseif ($response->getStatus() == RequestStatus::MORE_SIGNATURES_NEEDED) {
            throw new Exception\StepUpRequiredException('Transaction step up required.');
        } else {
            throw new Exception\RequestException($response->getStatus());
        }
    }

    /**
     * Lookup transactions and return response.
     *
     * @param string $accountId the account id
     * @param string $offset the offset
     * @param int $limit the limit
     * @param int $keyLevel the key level
     * @param string $startDate
     * @param string $endDate
     * @return PagedList list of transactions
     * @throws \Exception
     */
    public function getTransactions($accountId, $offset, $limit, $keyLevel, $startDate = null, $endDate = null)
    {
        $request = new GetTransactionsRequest();
        $request->setAccountId($accountId);
        $request->setPage($this->pageBuilder($limit, $offset));

        if ($startDate != null) {
            $request->setStartDate($startDate);
        }
        if ($endDate != null) {
            $request->setEndDate($endDate);
        }

        /** @var GetTransactionsResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf($keyLevel))
            ->GetTransactions($request));
        if ($response->getStatus() == RequestStatus::SUCCESSFUL_REQUEST) {
            return new PagedList($response->getTransactions(), $response->getOffset());
        } elseif ($response->getStatus() == RequestStatus::MORE_SIGNATURES_NEEDED) {
            throw new Exception\StepUpRequiredException("Transactions step up required.");
        } else {
            throw new Exception\RequestException($response->getStatus());
        }
    }

    /**
     * Returns linking information for the specified bank id.
     *
     * @param string $bankId the bank id
     * @return BankInfo linking information
     * @throws \Exception
     */
    public function getBankInfo($bankId)
    {
        $request = new GetBankInfoRequest();
        $request->setBankId($bankId);

        /** @var GetBankInfoResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->GetBankInfo($request));
        return $response->getInfo();
    }

    /**
     * Links a funding bank account to Token.
     *
     * @param  $authorization
     * @return RepeatedField
     * @throws Exception\BankAuthorizationRequiredException if bank authorization payload
     * @throws \Exception
     *     is required to link accounts
     */
    public function linkAccounts($authorization)
    {
        $request = new LinkAccountsOauthRequest();
        $request->setAuthorization($authorization);

        /** @var LinkAccountsOauthResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->LinkAccountsOauth($request));
        if ($response->getStatus() == AccountLinkingStatus::FAILURE_BANK_AUTHORIZATION_REQUIRED) {
            throw new Exception\BankAuthorizationRequiredException();
        }

        return $response->getAccounts();
    }

    /**
     * Creates a test bank account and links it.
     *
     * @param Money $balance account balance to set
     * @return
     * @throws \Exception
     */
    public function createAndLinkTestBankAccount($balance)
    {
        /** @var OauthBankAuthorization $authorization */
        $authorization = $this->createTestBankAuth($balance);
        $accounts = self::linkAccounts($authorization);

        if (sizeof($accounts) != 1) {
            throw new RuntimeException("Expected 1 account; found " . sizeof($accounts));
        }

        return $accounts[0];
    }

    /**
     * Returns a list of aliases of the member.
     *
     * @return RepeatedField
     * @throws \Exception
     */
    public function getAliases()
    {
        /** @var GetAliasesResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->GetAliases(new GetAliasesRequest()));
        return $response->getAliases();
    }

    /**
     * Retry alias verification.
     *
     * @param Alias $alias the alias to be verified
     * @return string $verificationId
     * @throws \Exception
     */
    public function retryVerification($alias)
    {
        $request = new RetryVerificationRequest();
        $request->setAlias($alias)
            ->setMemberId($this->memberId);

        /** @var RetryVerificationResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->RetryVerification($request));
        return $response->getVerificationId();
    }

    /**
     * Authorizes recovery as a trusted agent.
     *
     * @param Authorization $authorization the authorization
     * @return Signature
     */
    public function authorizeRecovery($authorization)
    {
        $signer = $this->cryptoEngine->createSigner(Level::STANDARD);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
            ->setKeyId($signer->getKeyId())
            ->setSignature($signer->sign($authorization));

        return $signature;
    }

    /**
     * Gets the member id of the default recovery agent.
     *
     * @return string the member id
     * @throws \Exception
     */
    public function getDefaultAgent()
    {
        /** @var GetDefaultAgentResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->GetDefaultAgent(new GetDefaultAgentRequest()));
        return $response->getMemberId();
    }

    /**
     * Verifies a given alias.
     *
     * @param string $verificationId the verification id
     * @param string $code the code
     * @return bool if operation succeed
     * @throws \Exception
     */
    public function verifyAlias($verificationId, $code)
    {
        $request = new VerifyAliasRequest();
        $request->setCode($code)
            ->setVerificationId($verificationId);

        /** @var VerifyAliasResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->VerifyAlias($request));
        return $response !== null;
    }

    /**
     * Delete the member.
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteMember()
    {
        /** @var DeleteMemberRequest $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext(Level::PRIVILEGED))
            ->DeleteMember(new DeleteMemberRequest()));
        return $response !== null;
    }

    /**
     * Resolves transfer destinations for the given account ID.
     *
     * @param string $accountId account ID
     * @return RepeatedField
     * @throws \Exception
     */
    public function resolveTransferDestinations($accountId)
    {
        $request = new ResolveTransferDestinationsRequest();
        $request->setAccountId($accountId);
        $response = Util::executeAndHandleCall(self::gateway($this->authenticateOnBehalfOf())
            ->ResolveTransferDestinations($request));

        /** @var ResolveTransferDestinationsResponse $response */
        return $response->getTransferDestinations();
    }

    /**
     * @return CryptoEngineInterface
     */
    public function getCryptoEngine()
    {
        return $this->cryptoEngine;
    }

    protected function authenticationContext($level = null)
    {
        if ($level != null) {
            return new AuthenticationContext(null, false, $level , $this->customerTrackingMetadata);
        }
        return new AuthenticationContext(null, false, Level::LOW, $this->customerTrackingMetadata);
    }

    protected function getOnBehalfOf()
    {
        return null;
    }

    protected function authenticateOnBehalfOf($level = Level::LOW)
    {
        return new AuthenticationContext($this->getOnBehalfOf(), $level, $this->customerInitiated, $this->customerTrackingMetadata);
    }

    /**
     * @param AuthenticationContext $authentication
     * @return GatewayServiceClient
     * @throws \Exception
     */
    protected function gateway($authentication)
    {
        $interceptors = array(new ClientAuthenticatorInterceptor($this->memberId, $this->cryptoEngine, $authentication));

        /** @var InterceptorChannel $channel */
        $channel = Interceptor::intercept($this->channel, $interceptors);

        return new GatewayServiceClient($channel->getTarget(), [], $channel);
    }

    protected function pageBuilder($limit, $offset = null)
    {
        $page = new Page();
        $page->setLimit($limit);

        if (!Strings::isEmptyString($offset)) {
            $page->setOffset($offset);
        }

        return $page;
    }

    /**
     * @param TokenPayload $payload
     * @param string $action
     * @return string
     */
    protected function tokenAction($payload, $action)
    {
        return sprintf('%s.%s', Util::toJson($payload), strtolower($action));
    }

    /**
     * @param Money $balance
     * @return OauthBankAuthorization
     * @throws \Exception
     */
    private function createTestBankAuth($balance)
    {
        $request = new CreateTestBankAccountRequest();
        $request->setBalance($balance);

        /** @var CreateTestBankAccountResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())
            ->CreateTestBankAccount($request));
        return $response->getAuthorization();
    }

}