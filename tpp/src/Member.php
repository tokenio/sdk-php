<?php

namespace Tokenio\Tpp;

use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Blob\Blob\AccessMode;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Eidas\VerifyEidasPayload;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Transfer\BulkTransfer;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Io\Token\Proto\Gateway\GetTokensRequest\Type;
use Io\Token\Proto\Gateway\SetTokenRequestTransferDestinationsResponse;
use Io\Token\Proto\Gateway\VerifyEidasResponse;
use Tokenio\TokenRequest;
use Tokenio\PagedList;
use Tokenio\TokenCluster;
use Tokenio\Util\Strings;
use Tokenio\Tpp\Rpc\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Member extends \Tokenio\Member implements RepresentableInterface
{

    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var Client
     */
    protected $client;


    /**
     * Creates an instance of {@link Member}.
     *
     * @param $memberId String member ID
     * @param $partnerId String member ID of partner
     * @param $realmId String
     * @param $client Client used to perform operations against the server
     * @param $cluster TokenCluster, e.g. sandbox, production
     */
    public function __construct($memberId, $partnerId=null, $realmId=null, $client, $cluster)
    {
        parent::__construct($memberId, $partnerId, $realmId, $client, $cluster);
        $this->client= $client;
        $this->logger = new Logger('Tokenio\Tpp\Member');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
    }

    /**
     * Replaces a member's public profile.
     * @param $profile Profile $profile to set
     * @return Profile which is set
     * @throws \Exception
     */
    public function setProfile($profile)
    {
        return $this->client->setProfile($profile);
    }

    /**
     * Replaces auth'd member's public profile picture.
     *
     * @param string $type MIME type of picture
     * @param string $data byte array representation image data
     * @return bool that indicates whether the operation finished or had an error
     * @throws \Exception
     */
    public function setProfilePicture($type, $data)
    {
        $payload = new Payload();
        $payload->setOwnerId($this->getMemberId())
            ->setType($type)
            ->setName('profile')
            ->setData($data)
            ->setAccessMode(AccessMode::PBPUBLIC);

        return $this->client->setProfilePicture($payload);
    }

    /**
     * Links a funding bank account to Token and returns it to the caller.
     *
     * @return Account[] list of accounts.
     * @throws \Exception
     */
    public function getAccounts()
    {
        $accounts = $this->getAccountsImpl();
        $result = [];

        /** @var  $account \Tokenio\Account */
        foreach ($accounts as $account) {
            $result[] = new Account($this, $account);
        }
        return $result;
    }

    /**
     * @param string $accountId
     * @return Account looked up account
     * @throws \Exception
     */
    public function getAccount($accountId)
    {
        $account= $this->getAccountImpl($accountId);
        return new Account($this, $account);
    }

    /**
     * @param $blobId string blobId id of the blob.
     * @return Blob
     * @throws \Exception
     */
    public function getBlob($blobId)
    {
        return $this->client->getBlob($blobId);
    }

    /**
     * @param $tokenId string token id.
     * @param $customerInitiated boolean
     * @return RepresentableInterface
     * @throws \Exception
     */
    public function forAccessToken($tokenId, $customerInitiated = false)
    {
        /** @var Client $cloned */
        $cloned= $this->client->forAccessToken($tokenId, $customerInitiated);
        return new Member($this->memberId, $this->partnerId, $this->realmId, $cloned, $this->cluster);
    }

    public function forAccessTokenWithTrackingMetadata(
            $tokenId,
            $customerTrackingMetadata) {
        $cloned = $this->client->forAccessTokenWithTrackingMetadata($tokenId, $customerTrackingMetadata);
        return new Member($this->memberId, $this->partnerId, $this->realmId, $cloned, $this->cluster);
    }

    /**
     * Redeems a transfer token.
     *
     * NOTE: destination should have type TransferDestination. Support for TransferEndpoint will be removed.
     *
     * @param Token $token the transfer token
     * @param double $amount the amount to transfer
     * @param string $currency the currency
     * @param string $description the description of the transfer
     * @param TransferDestination|TransferEndpoint $destination the transfer instruction destination
     * @param string $refId the reference id of the transfer
     * @return Transfer
     * @throws \Exception
     */
    public function redeemToken(
        $token,
        $amount = null,
        $currency = null,
        $description = null,
        $destination = null,
        $refId = null)
    {
        $payload = new TransferPayload();
        $payload->setTokenId($token->getId());
        $payload->setDescription($token->getPayload()->getDescription());

        if ($destination != null) {
            if ($destination instanceof TransferDestination) {
                $payload->setTransferDestinations(array($destination));
            } else {
                $payload->setDestinations(array($destination));
            }
        }

        if ($amount != null) {
            $money = new Money();
            $money->setValue(strval($amount));
            $payload->setAmount($money);
        }

        if ($currency != null) {
            if ($payload->getAmount() != null) {
                $payload->getAmount()->setCurrency($currency);
            } else {
                $money = new Money();
                $money->setCurrency($currency);
                $payload->setAmount($money);
            }
        }

        if ($description != null) {
            $payload->setDescription($description);
        }

        if ($refId != null) {
            $payload->setRefId($refId);
        } else if (!empty($token->getPayload()->getRefId() && $amount == null)) {
            $payload->setRefId($token->getPayload()->getRefId());
        } else {
            $this->logger->warn("refId is not set. A random ID will be used.");
            $payload->setRefId(Strings::generateNonce());
        }

        return $this->client->createTransfer($payload);
    }


    /**
     * @param $tokenId string ID of token to redeem
     * @return BulkTransfer record
     * @throws \Exception
     */

    public function redeemBulkTransferToken($tokenId)
    {
        return $this->client->createBulkTransfer($tokenId);
    }


    /**
     * Redeems a standing order token.
     *
     * @param string $tokenId ID of token to redeem
     * @return StandingOrderSubmission
     * @throws \Exception
     */
    public function redeemStandingOrderToken($tokenId)
    {
        return $this->client->createStandingOrder($tokenId);
    }


    /**
     * Stores a token request. This can be retrieved later by the token request id.
     *
     * @param TokenRequest $tokenRequest token request
     * @return string token request id
     * @throws \Exception
     */
    public function storeTokenRequest($tokenRequest)
    {
        return $this->client->storeTokenRequest(
            $tokenRequest->getTokenRequestPayload(),
            $tokenRequest->getTokenRequestOptions());
    }


    /**
     * @param $tokenRequestId string token request id
     * @param $transferDestinations TransferDestination[] destination account
     * @return SetTokenRequestTransferDestinationsResponse
     * @throws \Exception
     */
    public function setTokenRequestTransferDestinations($tokenRequestId, $transferDestinations)
    {
        return $this->client->setTokenRequestTransferDestinations($tokenRequestId, $transferDestinations);
    }


    /**
     * Creates a new web-app customization.
     *
     * @param string $name display name
     * @param Payload $logo blob payload of the logo
     * @param string $consentText consent text
     * @param array $colors a string dictionary that describes color schemes
     * @param string $appName corresponding app name.
     * @return string customization id
     * @throws \Exception
     */
    public function createCustomization($logo, $colors, $consentText, $name, $appName)
    {
        return $this->client->createCustomization($logo, $colors, $consentText, $name, $appName);
    }

    /**
     * Looks up an existing token transfer.
     *
     * @param string $transferId ID of the transfer record
     * @return Transfer record
     * @throws \Exception
     */
    public function getTransfer($transferId)
    {
        return $this->client->getTransfer($transferId);
    }


    /**
     * @param $bulkTransferId string bulk transfer id.
     * @return BulkTransfer bulk transfer record.
     * @throws \Exception
     */
    public function getBulkTransfer($bulkTransferId)
    {
        return $this->client->getBulkTransfer($bulkTransferId);
    }

    /**
     * Looks up an existing Token standing order submission.
     *
     * @param string $submissionId submission id
     * @return StandingOrderSubmission record
     * @throws \Exception
     */
    public function getStandingOrderSubmission($submissionId)
    {
        return $this->client->getStandingOrderSubmission($submissionId);
    }

    /**
     * Looks up a list of existing transfers.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param string $tokenId optional token id to restrict the search
     * @return PagedList containing transfer records
     * @throws \Exception
     */
    public function getTransfers($offset = null, $limit, $tokenId = null)
    {
        return $this->client->getTransfers($offset, $limit, $tokenId);
    }

    /**
     * Looks up a list of existing standing order submissions.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @return PagedList containing standing order records
     * @throws \Exception
     */
    public function getStandingOrderSubmissions($offset = null, $limit)
    {
        return $this->client->getStandingOrderSubmissions( $offset, $limit);
    }

    /**
     * @param $toMemberId string beneficiary of the active access token
     * @return Token access token returned by the server
     * @throws \Exception
     */
    public function getActiveAccessToken($toMemberId)
    {
        return $this->client->getActiveAccessToken($toMemberId);
    }

    /**
     * @param $offset string optional offset to start at
     * @param $limit int max number of records to return
     * @return PagedList
     * @throws \Exception
     */
    public function getAccessTokens($offset= null, $limit)
    {
        return $this->client->getTokens(Type::ACCESS, $offset, $limit);
    }

    /**
     * @param $offset string optional offset to start at
     * @param $limit int max number of records to return
     * @return PagedList transfer tokens owned by the member
     * @throws \Exception
     */
    public function getTransferTokens($offset= null, $limit)
    {
        return $this->client->getTokens(Type::TRANSFER, $offset, $limit);
    }

    /**
     * @param $tokenId string token id
     * @return Token token returned by the serve
     * @throws \Exception
     */
    public function getToken($tokenId)
    {
        return $this->client->getToken($tokenId);
    }

    /**
     * @param $token Token token to cancel
     * @return TokenOperationResult result of cancel token
     * @throws \Exception
     */
    public function cancelToken($token)
    {
        return $this->client->cancelToken($token);
    }

    /**
     * @param $accountIds string[] list of account ids
     * @return int notification status
     * @throws \Exception
     */
    public function triggerBalanceStepUpNotification($accountIds)
    {
        return $this->client->triggerBalanceStepUpNotification($accountIds);
    }

    /**
     * Trigger a step up notification for transaction requests.
     *
     * @param string account id
     * @return int notification status
     * @throws \Exception
     */
    public function triggerTransactionStepUpNotification($accountId)
    {
        return $this->client->triggerTransactionStepUpNotification($accountId);
    }

    /**
     * @param $balance double account balance to set
     * @param $currency string currency code, e.g. "EUR"
     * @return \Tokenio\Tpp\Account the linked account
     * @throws \Exception
     */
    public function createTestBankAccount($balance, $currency)
    {
        $testBankAccount= $this->createTestBankAccountImpl($balance, $currency);
        return new Account($this, $testBankAccount);
    }

    /**
     * @param $payload VerifyEidasPayload containing the member id and the base64 encoded eIDAS certificate
     * @param $signature string signature the payload signed with a private key corresponding to the certificate
     * @return VerifyEidasResponse a result of the verification process
     * @throws \Exception
     */
    public function verifyEidas($payload, $signature)
    {
        return $this->client->verifyEidas($payload, $signature);
    }
}