<?php

namespace Tokenio\Http;

use Google\Protobuf\Internal\MapField;
use Io\Token\Proto\Common\Account\Account;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberOperationMetadata;
use Io\Token\Proto\Common\Member\MemberUpdate;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\RequestStatus;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Gateway\CreateBlobRequest;
use Io\Token\Proto\Gateway\CreateBlobResponse;
use Io\Token\Proto\Gateway\CreateTransferRequest;
use Io\Token\Proto\Gateway\CreateTransferResponse;
use Io\Token\Proto\Gateway\GetAccountRequest;
use Io\Token\Proto\Gateway\GetAccountResponse;
use Io\Token\Proto\Gateway\GetAccountsRequest;
use Io\Token\Proto\Gateway\GetAccountsResponse;
use Io\Token\Proto\Gateway\GetActiveAccessTokenRequest;
use Io\Token\Proto\Gateway\GetActiveAccessTokenResponse;
use Io\Token\Proto\Gateway\GetAliasesRequest;
use Io\Token\Proto\Gateway\GetBalanceRequest;
use Io\Token\Proto\Gateway\GetBalanceResponse;
use Io\Token\Proto\Gateway\GetBalancesRequest;
use Io\Token\Proto\Gateway\GetBalancesResponse;
use Io\Token\Proto\Gateway\GetMemberRequest;
use Io\Token\Proto\Gateway\GetMemberResponse;
use Io\Token\Proto\Gateway\GetTokenRequest;
use Io\Token\Proto\Gateway\GetTokenResponse;
use Io\Token\Proto\Gateway\GetTransactionRequest;
use Io\Token\Proto\Gateway\GetTransactionResponse;
use Io\Token\Proto\Gateway\GetTransactionsRequest;
use Io\Token\Proto\Gateway\GetTransactionsResponse;
use Io\Token\Proto\Gateway\Page;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Gateway\StoreTokenRequestRequest;
use Io\Token\Proto\Gateway\StoreTokenRequestResponse;
use Io\Token\Proto\Gateway\UpdateMemberRequest;
use Io\Token\Proto\Gateway\UpdateMemberResponse;
use Tokenio\Exception;
use Tokenio\Util\PagedList;
use Tokenio\Util\Strings;
use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Proto\Gateway\GetAliasesResponse;
use Tokenio\Security\CryptoEngineInterface;

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
     * Returns a list of aliases of the member.
     *
     * @return RepeatedField
     */
    public function getAliases()
    {
        /** @var GetAliasesResponse $response */
        list($response) = $this->gateway->GetAliases(new GetAliasesRequest())->wait();
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
        list($response) = $this->gateway->GetMember($request)->wait();
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
        list($response) = $this->gateway->GetAccount($request)->wait();
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
        list($response) = $this->gateway->GetAccounts(new GetAccountsRequest())->wait();
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
        list($response) = $this->gateway->UpdateMember($request)->wait();
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
        list($response) = $this->gateway->GetBalance($request)->wait();
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
        list($response) = $this->gateway->GetBalances($request)->wait();

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
        list($response) = $this->gateway->GetTransaction($request)->wait();
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
        list($response) = $this->gateway->GetTransactions($request)->wait();
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
        list($response) = $this->gateway->GetToken($request)->wait();
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
        list($response) = $this->gateway->GetActiveAccessToken($request)->wait();
        return $response->getToken();
    }

    private function pageBuilder($limit, $offset = null)
    {
        $page = new Page();
        $page->setLimit($limit);

        if (!Strings::isEmptyString($offset)) {
            $page->setOffset($offset);
        }

        return $offset;
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
        list($response) = $this->gateway->StoreTokenRequest($request)->wait();
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
        list($response) = $this->gateway->CreateBlob($request)->wait();
        return $response->getBlobId();
    }

    /**
     * Creates a transfer redeeming a transfer token.
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
        list($response) = $this->gateway->CreateTransfer($request)->wait();
        return $response->getTransfer();
    }
}