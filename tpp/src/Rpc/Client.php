<?php

namespace Tokenio\Tpp\Rpc;

use Exception;
use Grpc\Channel;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Eidas\VerifyEidasPayload;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Notification\BalanceStepUp;
use Io\Token\Proto\Common\Notification\TransactionStepUp;
use Io\Token\Proto\Common\Security\CustomerTrackingMetadata;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\SecurityMetadata;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Gateway\CancelTokenRequest;
use Io\Token\Proto\Gateway\CancelTokenResponse;
use Io\Token\Proto\Gateway\CreateCustomizationRequest;
use Io\Token\Proto\Gateway\CreateCustomizationResponse;
use Io\Token\Proto\Gateway\CreateTransferRequest;
use Io\Token\Proto\Gateway\CreateTransferResponse;
use Io\Token\Proto\Gateway\GetActiveAccessTokenRequest;
use Io\Token\Proto\Gateway\GetActiveAccessTokenResponse;
use Io\Token\Proto\Gateway\GetBlobRequest;
use Io\Token\Proto\Gateway\GetBlobResponse;
use Io\Token\Proto\Gateway\GetTokenRequest;
use Io\Token\Proto\Gateway\GetTokenResponse;
use Io\Token\Proto\Gateway\GetTokensRequest;
use Io\Token\Proto\Gateway\GetTokensResponse;
use Io\Token\Proto\Gateway\GetTransferRequest;
use Io\Token\Proto\Gateway\GetTransferResponse;
use Io\Token\Proto\Gateway\GetTransfersRequest;
use Io\Token\Proto\Gateway\GetTransfersResponse;
use Io\Token\Proto\Gateway\SetProfilePictureRequest;
use Io\Token\Proto\Gateway\SetProfilePictureResponse;
use Io\Token\Proto\Gateway\SetProfileRequest;
use Io\Token\Proto\Gateway\SetProfileResponse;
use Io\Token\Proto\Gateway\StoreTokenRequestRequest;
use Io\Token\Proto\Gateway\StoreTokenRequestResponse;
use Io\Token\Proto\Gateway\TriggerStepUpNotificationRequest;
use Io\Token\Proto\Gateway\TriggerStepUpNotificationResponse;
use Io\Token\Proto\Gateway\VerifyEidasRequest;
use Io\Token\Proto\Gateway\VerifyEidasResponse;
use Tokenio\Exception\StatusRuntimeException;
use Tokenio\PagedList;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Util\Util;

class Client extends \Tokenio\Rpc\Client
{
    protected $securityMetadata;

    protected $onBehalfOf;
    /**
     * Creates a client instance.
     *
     * @param $memberId string member id
     * @param $crypto CryptoEngineInterface the crypto engine used to sign for authentication, request payloads, etc
     * @param $channel Channel gateway gRPC stub
     */
    public function __construct($memberId, $crypto, $channel)
    {
        parent::__construct($memberId, $crypto, $channel);
        $this->securityMetadata = new SecurityMetadata();
    }

    /**
     * Replaces a member's public profile.
     *
     * @param Profile $profile to set
     * @return Profile which is set
     * @throws Exception
     */
    public function setProfile($profile)
    {
        $request = new SetProfileRequest();
        $request->setProfile($profile);
        /** @var SetProfileResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->SetProfile($request));
        return $response->getProfile();
    }

    /**
     * Replaces a member's public profile picture.
     *
     * @param $payload Blob\Payload  Picture data
     * @return bool that completes when request handled
     * @throws Exception
     */
    public function setProfilePicture($payload)
    {
        $request = new SetProfilePictureRequest();
        $request->setPayload($payload);

        /** @var SetProfilePictureResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->SetProfilePicture($request));
        return $response !== null;
    }

    /**
     * Retrieves a blob from the server.
     *
     * @param  $blobId string id of the blob
     * @return Blob
     * @throws Exception
     */
    public function getBlob($blobId)
    {
        $request = new GetBlobRequest();
        $request->setBlobId($blobId);
        /** @var GetBlobResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetBlob($request));
        return $response != null ? $response->getBlob() : null;
    }

    /**
     * Creates a new instance with On-Behalf-Of authentication set.
     *
     * @param $tokenId string access token ID to be used
     * @param $customerInitiated boolean whether the customer initiated the calls
     * @return client instance
     * @throws Exception
     */
    public function forAccessToken($tokenId, $customerInitiated)
    {
        $updated = new Client($this->memberId, $this->cryptoEngine, $this->channel);
        $updated->useAccessToken($tokenId, $customerInitiated);
        $updated->setSecurityMetadata($this->securityMetadata);
        return $updated;
    }

    private function setSecurityMetadata($securityMetadata)
    {
        $this->securityMetadata = $securityMetadata;
    }
    /**
     * Creates a new instance with On-Behalf-Of authentication set.
     *
     * @param string $tokenId access token ID to be used
     * @param CustomerTrackingMetadata $customerTrackingMetadata customer tracking metadata
     * @return Client
     */
    public function forAccessTokenWithTrackingMetadata(
            $tokenId,
            $customerTrackingMetadata) {
        if ($customerTrackingMetadata === new CustomerTrackingMetadata()) {
            throw new StatusRuntimeException(
                "INVALID_ARGUMENT",
                "User tracking metadata is empty. Use forAccessToken(String, boolean) instead.");
        }
        $updated = new Client($this->memberId, $this->cryptoEngine, $this->channel);
        $updated->useAccessTokenWithTrackingMetadata($tokenId, $customerTrackingMetadata);
        return $updated;
    }

    /**
     * Sets the On-Behalf-Of authentication value to be used
     * with this client.  The value must correspond to an existing
     * Access Token ID issued for the client member. Uses the given customer
     * initiated flag.
     *
     * @param $accessTokenId string access token id to be used
     * @param $customerInitiated boolean whether the customer initiated the calls
     */
    private function useAccessToken($accessTokenId, $customerInitiated)
    {
        $this->onBehalfOf = $accessTokenId;
        $this->customerInitiated = $customerInitiated;
    }

    /**
     * Sets the On-Behalf-Of authentication value to be used
     * with this client.  The value must correspond to an existing
     * Access Token ID issued for the client member. Uses the given customer
     * initiated flag.
     *
     * @param string $accessTokenId the access token id to be used
     * @param CustomerTrackingMetadata $customerTrackingMetadata the tracking metadata of the customer
     */
    private function useAccessTokenWithTrackingMetadata(
            $accessTokenId,
            $customerTrackingMetadata) {
        $this->onBehalfOf = $accessTokenId;
        $this->customerInitiated = true;
        $this->customerTrackingMetadata = $customerTrackingMetadata;
    }

    /**
     * Stores a token request.
     *
     * @param TokenRequestPayload $payload immutable token request fields
     * @param TokenRequestOptions $options mutable token request fields
     * @return string id to reference token request
     * @throws Exception
     */
    public function storeTokenRequest($payload, $options)
    {
        $request = new StoreTokenRequestRequest();
        $request
            ->setRequestPayload($payload)
            ->setRequestOptions($options);

        /** @var StoreTokenRequestResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->StoreTokenRequest($request));
        return $response->getTokenRequest()->getId();
    }

    /**
     * Creates a new web-app customization.
     *
     * @param $logo Blob\Payload blob payload of the logo
     * @param $consentText string consent text
     * @param $colors array a string dictionary that describes color schemes
     * @param $name string display name
     * @param $appName string display app name
     * @return string customization id
     * @throws Exception
     */
    public function createCustomization($logo, $colors, $consentText, $name, $appName)
    {
        $request = new CreateCustomizationRequest();
        $request->setName($name)
                ->setLogo($logo)
                ->setConsentText($consentText)
                ->setColors($colors)
                ->setAppName($appName);

        /* @var CreateCustomizationResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateCustomization($request));
        return $response->getCustomizationId();
        }

    /**
     * Looks up a existing access token where the calling member is the granter and given member is
     * the grantee.
     *
     * @param $toMemberId string beneficiary of the active access token
     * @return Token token returned by the server
     * @throws Exception
     */
    public function getActiveAccessToken($toMemberId)
    {
        $request = new GetActiveAccessTokenRequest();
        $request->setToMemberId($toMemberId);

        /** @var GetActiveAccessTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetActiveAccessToken($request));
        return $response->getToken();
    }

    /**
     * Looks up a list of existing token.
     *
     * @param $type int $type token type
     * @param $offset string $offset optional offset to start at
     * @param $limit int  max number of records to return
     * @return PagedList returned by the server
     * @throws Exception
     */
    public function getTokens($type, $offset = null, $limit)
    {
        $request = new GetTokensRequest();
        $request->setType($type)
            ->setPage($this->pageBuilder($limit, $offset));

        /** @var GetTokensResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetTokens($request));
        return new PagedList($response->getTokens(), $response->getOffset());
    }

    /**
     * Looks up a existing token.
     *
     * @param $tokenId string token id
     * @return Token token returned by the server
     * @throws Exception
     */
    public function getToken($tokenId)
    {
        $request = new GetTokenRequest();
        $request->setTokenId($tokenId);

        /** @var GetTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetToken($request));
        return $response->getToken();
    }

    /**
     * Looks up an existing transfer.
     *
     * @param  $transferId string transfer id
     * @return Transfer record
     * @throws Exception
     */
    public function getTransfer($transferId)
    {
        $request = new GetTransferRequest();
        $request->setTransferId($transferId);

        /** @var GetTransferResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetTransfer($request));
        return $response->getTransfer();
    }


    /**
     * Looks up a list of existing transfers.
     *
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param string $tokenId optional token id to restrict the search
     * @return PagedList containing transfer records
     * @throws Exception
     */
    public function getTransfers($offset = null, $limit, $tokenId = null)
    {
        $request = new GetTransfersRequest();
        $request->setPage($this->pageBuilder($limit, $offset));
        if ($tokenId !== null) {
            $filter = new GetTransfersRequest\TransferFilter();
            $filter->setTokenId($tokenId);
            $request->setFilter($filter);
        }
        /** @var GetTransfersResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetTransfers($request));
        return new PagedList($response->getTransfers(), $response->getOffset());
    }

    /**
     * Redeems a transfer token.
     *
     * @param $transfer TransferPayload  the transfer payload
     * @return Transfer
     * @throws Exception
     */
    public function createTransfer($transfer)
    {
        $signer = $this->cryptoEngine->createSigner(Key\Level::LOW);

        $payloadSignature = new Signature();
        $payloadSignature->setMemberId($this->memberId);
        $payloadSignature->setKeyId($signer->getKeyId());
        $payloadSignature->setSignature($signer->sign($transfer));

        $request = new CreateTransferRequest();
        $request->setPayload($transfer);
        $request->setPayloadSignature($payloadSignature);

        /** @var CreateTransferResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateTransfer($request));
        return $response->getTransfer();
    }

    /**
     * Cancels a token.
     *
     * @param Token $token to cancel
     * @return TokenOperationResult result of the cancel operation, returned by the server
     * @throws Exception
     */
    public function cancelToken($token)
    {
        $signer = $this->cryptoEngine->createSigner(Key\Level::LOW);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
            ->setKeyId($signer->getKeyId())
            ->setSignature($signer->signString($this->tokenAction($token->getPayload(),"CANCELLED")));

        /* @var $request CancelTokenRequest */
        $request = new CancelTokenRequest();
        $request->setTokenId($token->getId())
            ->setSignature($signature);

        /** @var CancelTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CancelToken($request));
        return $response->getResult();
    }

    /**
     * Trigger a step up notification for balance requests.
     *
     * @param $accountIds String[] list of account ids
     * @return int status
     * @throws Exception
     */
    public function triggerBalanceStepUpNotification($accountIds)
    {
        $balanceStepUp = new BalanceStepUp();
        $balanceStepUp->setAccountId($accountIds);
        $stepUpNotificationRequest = new TriggerStepUpNotificationRequest();
        $stepUpNotificationRequest->setBalanceStepUp($balanceStepUp);

        /** @var TriggerStepUpNotificationResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->TriggerStepUpNotification($stepUpNotificationRequest));
        return $response->getStatus();
    }

    /**
     * Trigger a step up notification for transaction requests.
     *
     * @param $accountId String[] account id
     * @return int status
     * @throws Exception
     */
    public function triggerTransactionStepUpNotification($accountId)
    {
        $transactionStepUp = new TransactionStepUp();
        $transactionStepUp->setAccountId($accountId);
        $stepUpNotificationRequest = new TriggerStepUpNotificationRequest();
        $stepUpNotificationRequest->setTransactionStepUp($transactionStepUp);

        /** @var TriggerStepUpNotificationResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->TriggerStepUpNotification($stepUpNotificationRequest));
        return $response->getStatus();
    }

    /**
     * Verifies eIDAS certificate.
     *
     * @param $payload VerifyEidasPayload containing member id, eIDAS alias and the certificate
     * @param $signature string signed with the private key corresponding to the certificate
     * @return VerifyEidasResponse of the verification operation, returned by the server
     * @throws Exception
     */
    public function verifyEidas($payload, $signature)
    {
        $request = new VerifyEidasRequest();
        $request->setPayload($payload)
                ->setSignature($signature);

        /** @var VerifyEidasResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->VerifyEidas($request));
        return $response;
    }


    /**
     * @return string
     */
    protected function getOnBehalfOf() {
        return $this->onBehalfOf;
    }
}