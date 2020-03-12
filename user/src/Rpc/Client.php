<?php

namespace Tokenio\User\Rpc;

use Exception;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\Internal\RepeatedField;
use Grpc\Channel;
use Io\Token\Proto\Banklink\AccountLinkingStatus;
use Io\Token\Proto\Banklink\BankAuthorization;
use Io\Token\Proto\Banklink\OauthBankAuthorization;
use Io\Token\Proto\Common\Account\Account;
use Io\Token\Proto\Common\Blob\Blob\Payload;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\ReceiptContact;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Io\Token\Proto\Common\Token\TransferTokenStatus;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transfer\TransferPayload;
use Io\Token\Proto\Gateway\ApplyScaRequest;
use Io\Token\Proto\Gateway\CancelTokenRequest;
use Io\Token\Proto\Gateway\CancelTokenResponse;
use Io\Token\Proto\Gateway\CreateAccessTokenRequest;
use Io\Token\Proto\Gateway\CreateAccessTokenResponse;
use Io\Token\Proto\Gateway\CreateTokenRequest;
use Io\Token\Proto\Gateway\CreateTokenResponse;
use Io\Token\Proto\Gateway\CreateTransferRequest;
use Io\Token\Proto\Gateway\CreateTransferResponse;
use Io\Token\Proto\Gateway\CreateTransferTokenRequest;
use Io\Token\Proto\Gateway\EndorseTokenRequest;
use Io\Token\Proto\Gateway\EndorseTokenResponse;
use Io\Token\Proto\Gateway\GetActiveAccessTokenRequest;
use Io\Token\Proto\Gateway\GetDefaultAccountRequest;
use Io\Token\Proto\Gateway\GetNotificationRequest;
use Io\Token\Proto\Gateway\GetNotificationResponse;
use Io\Token\Proto\Gateway\GetNotificationsRequest;
use Io\Token\Proto\Gateway\GetNotificationsResponse;
use Io\Token\Proto\Gateway\GetReceiptContactRequest;
use Io\Token\Proto\Gateway\GetReceiptContactResponse;
use Io\Token\Proto\Gateway\GetSubscriberRequest;
use Io\Token\Proto\Gateway\GetSubscriberResponse;
use Io\Token\Proto\Gateway\GetSubscribersRequest;
use Io\Token\Proto\Gateway\GetSubscribersResponse;
use Io\Token\Proto\Gateway\GetTokenRequest;
use Io\Token\Proto\Gateway\GetTokenResponse;
use Io\Token\Proto\Gateway\GetTokensRequest;
use Io\Token\Proto\Gateway\GetTokensResponse;
use Io\Token\Proto\Gateway\GetTransferRequest;
use Io\Token\Proto\Gateway\GetTransferResponse;
use Io\Token\Proto\Gateway\GetTransfersRequest;
use Io\Token\Proto\Gateway\GetTransfersResponse;
use Io\Token\Proto\Gateway\LinkAccountsRequest;
use Io\Token\Proto\Gateway\LinkAccountsResponse;
use Io\Token\Proto\Gateway\PrepareTokenRequest;
use Io\Token\Proto\Gateway\ReplaceTokenRequest;
use Io\Token\Proto\Gateway\ReplaceTokenRequest\CancelToken;
use Io\Token\Proto\Gateway\ReplaceTokenRequest\CreateToken;
use Io\Token\Proto\Gateway\SetAppCallbackUrlRequest;
use Io\Token\Proto\Gateway\SetDefaultAccountRequest;
use Io\Token\Proto\Gateway\SetProfilePictureRequest;
use Io\Token\Proto\Gateway\SetProfilePictureResponse;
use Io\Token\Proto\Gateway\SetProfileRequest;
use Io\Token\Proto\Gateway\SetProfileResponse;
use Io\Token\Proto\Gateway\SetReceiptContactRequest;
use Io\Token\Proto\Gateway\SignTokenRequestStateRequest;
use Io\Token\Proto\Gateway\SignTokenRequestStateResponse;
use Io\Token\Proto\Gateway\StoreLinkingRequestRequest;
use Io\Token\Proto\Gateway\SubscribeToNotificationsRequest;
use Io\Token\Proto\Gateway\SubscribeToNotificationsResponse;
use Io\Token\Proto\Gateway\UnlinkAccountsRequest;
use Io\Token\Proto\Gateway\UnlinkAccountsResponse;
use Io\Token\Proto\Gateway\UnsubscribeFromNotificationsRequest;
use Io\Token\Proto\Gateway\UnsubscribeFromNotificationsResponse;
use Io\Token\Proto\Gateway\UpdateNotificationStatusRequest;
use Io\Token\Proto\Gateway\UpdateNotificationStatusResponse;
use Tokenio\PagedList;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\User\Exception\TransferTokenException;
use Tokenio\User\PrepareTokenResult;
use Tokenio\User\Util\Util;

class Client extends \Tokenio\Rpc\Client
{
    /**
     * Construct the Client.
     *
     * @param string $memberId the member id
     * @param CryptoEngineInterface $crypto the crypto engine used to sign for authentication, request payloads, etc
     * @param Channel $channel the RPC channel to use
     */
    public function __construct($memberId, $crypto, $channel)
    {
        parent::__construct($memberId, $crypto, $channel);
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
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SetProfile($request));
        return $response->getProfile();
    }

    /**
     * Replaces a member's public profile picture.
     *
     * @param Payload $payload Picture data
     * @return bool that completes when request handled
     * @throws Exception
     */
    public function setProfilePicture($payload)
    {
        $request = new SetProfilePictureRequest();
        $request->setPayload($payload);

        /** @var SetProfilePictureResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SetProfilePicture($request));
        return $response !== null;
    }


    /**
     *  Makes RPC to get default bank account for this member.
     *
     * @param $memberId string
     * @return Account
     * @throws Exception
     */
    public function getDefaultAccount($memberId)
    {
        $request = new GetDefaultAccountRequest();
        $request->setMemberId($memberId);

        /* @var \Io\Token\Proto\Gateway\GetDefaultAccountResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetDefaultAccount($request));
        return $response->getAccount();
    }


    /**
     * Makes RPC to set default bank account.
     *
     * @param $accountId string the bank account id
     * @return Message
     * @throws Exception
     */
    public function setDefaultAccount($accountId)
    {
        $request = new SetDefaultAccountRequest();
        $request->setMemberId($this->memberId);
        $request->setAccountId($accountId);

        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SetDefaultAccount($request));
        return $response;
    }

    /**
     * @param $accountId string
     * @return bool
     * @throws Exception
     */
    public function isDefault($accountId)
    {
        $request = new GetDefaultAccountRequest();
        $request->setMemberId($this->memberId);

        /* @var \Io\Token\Proto\Gateway\GetDefaultAccountResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetDefaultAccount($request));
        return ($response->getAccount()->getId() === $accountId)? true : false;
    }


    /**
     * Looks up an existing transfer.
     *
     * @param string $transferId transfer id
     * @return Transfer record
     * @throws Exception
     */
    public function getTransfer($transferId)
    {
        $request = new GetTransferRequest();
        $request->setTransferId($transferId);

        /** @var GetTransferResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetTransfer($request));
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
    public function getTransfers($offset, $limit, $tokenId)
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
     * @param $payload TokenPayload
     * @return PrepareTokenResult
     * @throws Exception
     */
    public function prepareToken($payload)
    {
        $request = new PrepareTokenRequest();
        $request->setPayload($payload);
        /* @var \Io\Token\Proto\Gateway\PrepareTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->PrepareToken($request));
        return PrepareTokenResult::create($response->getResolvedPayload(), $response->getPolicy());
    }


    /**
     * Creates a new token.
     *
     * @param $payload TokenPayload
     * @param $tokenRequestId string
     * @param $signatures Signature[]
     * @return Token
     * @throws Exception
     */
    public function createToken($payload, $tokenRequestId, $signatures)
    {
        /* @var $request CreateTokenRequest */
        $request = new CreateTokenRequest();
        $request->setPayload($payload);

        if($tokenRequestId !== null)
        {
            $request->setTokenRequestId($tokenRequestId);
        }
        if(!empty($signatures))
        {
            $request->setSignatures($signatures);
        }
        /* @var $response CreateTokenResponse */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateToken($request));
        return $response->getToken();
    }

    /**
     * Creates a new transfer token.
     *
     * @param $payload TokenPayload
     * @param $tokenRequestId string
     * @return Token
     * @throws Exception
     */
    public function createTransferToken($payload, $tokenRequestId= null)
    {
        $request= new CreateTransferTokenRequest();
        $request->setPayload($payload);
        if($tokenRequestId !== null)
        {
            $request->setTokenRequestId($tokenRequestId);
        }
        /* @var $response \Io\Token\Proto\Gateway\CreateTransferTokenResponse */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateTransferToken($request));
        if($response->getStatus() !== TransferTokenStatus::SUCCESS){
            throw new TransferTokenException($response->getStatus());
        }
        return $response->getToken();
    }

    /**
     * Creates a new access token.
     *
     * @param $tokenPayload TokenPayload
     * @param $tokenRequestId string
     * @return Token returned by the server
     * @throws Exception
     */
    public function createAccessToken($tokenPayload, $tokenRequestId= null)
    {
        $request = new CreateAccessTokenRequest();
        $request->setPayload($tokenPayload);
        if($tokenRequestId !== null)
        {
            $request->setTokenRequestId($tokenRequestId);
        }

        /** @var CreateAccessTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateAccessToken($request));
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
     * @throws Exception
     */
    public function endorseToken($token, $keyLevel)
    {
        $signer = $this->cryptoEngine->createSigner($keyLevel);
        $signature = new Signature();
        $signature->setMemberId($this->memberId)
            ->setKeyId($signer->getKeyId())
            ->setSignature($signer->signString($this->tokenAction($token->getPayload(), 'ENDORSED')));
        $request = new EndorseTokenRequest();
        $request->setTokenId($token->getId())
            ->setSignature($signature);

        /** @var EndorseTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->EndorseToken($request));
        return $response->getResult();
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
            ->setSignature($signer->signString($this->tokenAction($token->getPayload(), 'CANCELLED')));

        $request = new CancelTokenRequest();
        $request->setTokenId($token->getId())
            ->setSignature($signature);

        /** @var CancelTokenResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CancelToken($request));
        return $response->getResult();
    }


    /**
     * Cancels the existing token and creates a replacement for it.
     * Supported only for access tokens.
     *
     * @param $tokenToCancel Token
     * @param $tokenToCreate TokenPayload
     * @return TokenOperationResult
     * @throws Exception
     */
    public function replace($tokenToCancel, $tokenToCreate)
    {
        $newToken = new CreateToken();
        $newToken->setPayload($tokenToCreate);
        return $this->cancelAndReplace($tokenToCancel, $newToken);
    }


    /**
     * @param $contact ReceiptContact
     * @return Message
     * @throws Exception
     */
    public function setReceiptContact($contact)
    {
        $request = new SetReceiptContactRequest();
        $request->setContact($contact);

        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->SetReceiptContact($request));
        return $response;
    }

    /**
     * Gets a member's receipt contact.
     *
     * @return ReceiptContact
     * @throws Exception
     */
    public function getReceiptContact()
    {
        $request = new GetReceiptContactRequest();

        /* @var GetReceiptContactResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetReceiptContact($request));
        return $response->getContact();
    }

    /**
     * Looks up a existing access token where the calling member is the grantor and given member is
     * the grantee.
     *
     * @param $toMemberId string beneficiary of the active access token
     * @return Token
     * @throws Exception
     */
    public function getActiveAccessToken($toMemberId)
    {
        $request = new GetActiveAccessTokenRequest();
        $request->setToMemberId($toMemberId);

        /* @var $response \Io\Token\Proto\Gateway\GetActiveAccessTokenResponse */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetActiveAccessToken($request));
        return $response->getToken();
    }

    /**
     * Looks up a list of existing token.
     *
     * @param int $type token type
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @return PagedList returned by the server
     * @throws Exception
     */
    public function getTokens($type, $offset, $limit)
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
        $response =Util::executeAndHandleCall(self::gateway(self::authenticationContext())->GetToken($request));
        return $response->getToken();
    }

    /**
     * Redeems a transfer token.
     *
     * @param TransferPayload $payload the transfer payload
     * @return Transfer
     * @throws Exception
     */
    public function createTransfer($payload)
    {
        $signer = $this->cryptoEngine->createSigner(Key\Level::LOW);

        $payloadSignature = new Signature();
        $payloadSignature->setMemberId($this->memberId);
        $payloadSignature->setKeyId($signer->getKeyId());
        $payloadSignature->setSignature($signer->sign($payload));

        $request = new CreateTransferRequest();
        $request->setPayload($payload);
        $request->setPayloadSignature($payloadSignature);

        /** @var CreateTransferResponse $response */
        $response = Util::executeAndHandleCall(self::gateway(self::authenticationContext())->CreateTransfer($request));
        return $response->getTransfer();
    }


    /**
     * Links a funding bank account to Token.
     *
     * @param $authorization
     * @return RepeatedField
     * @throws Exception
     */
    public function linkAccounts($authorization)
    {
        if($authorization instanceof BankAuthorization) {
            $request = new LinkAccountsRequest();
            $request->setBankAuthorization($authorization);

            /** @var LinkAccountsResponse $response */
            $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->LinkAccounts($request));
            return $response->getAccounts();
        }
        elseif($authorization instanceof OauthBankAuthorization)
        {
            return parent::linkAccounts($authorization);
        }
    }

    /**
     * @param $accountIds string[] account ids to unlink
     * @return UnlinkAccountsResponse
     * @throws Exception
     */
    public function unlinkAccounts($accountIds)
    {
        $request = new UnlinkAccountsRequest();
        $request->setAccountIds($accountIds);

        /** @var UnlinkAccountsResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext()) ->UnlinkAccounts($request));
        return $response;
    }

    /**
     * @param $subscriberId string
     * @return UnsubscribeFromNotificationsResponse
     * @throws Exception
     */
    public function unsubscribeFromNotifications($subscriberId)
    {
        $request = new UnsubscribeFromNotificationsRequest();
        $request->setSubscriberId($subscriberId);

        /** @var UnsubscribeFromNotificationsResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext()) ->UnsubscribeFromNotifications($request));
        return $response;
    }

    /**
     * @param $offset string offset to start
     * @param $limit int
     * @return PagedList
     * @throws Exception
     */
    public function getNotifications($offset, $limit)
    {
        $request = new GetNotificationsRequest();
        $request->setPage($this->pageBuilder($limit, $offset));

        /* @var $response GetNotificationsResponse*/
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext()) ->GetNotifications($request));
        return new PagedList($response->getNotifications(), $response->getOffset());
    }


    /**
     * Updates the status of a notification.
     *
     * @param $notificationId string
     * @param $status int
     * @return UpdateNotificationStatusResponse
     * @throws Exception
     */
    public function updateNotificationStatus($notificationId, $status)
    {
        $request = new UpdateNotificationStatusRequest();
        $request->setNotificationId($notificationId);
        $request->setStatus($status);

        /** @var UpdateNotificationStatusResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext()) ->UpdateNotificationStatus($request));
        return $response;
    }

    /**
     * Gets a notification.
     *
     * @param $notificationId string
     * @throws Exception
     */
    public function getNotification($notificationId)
    {
        $request = new GetNotificationRequest();
        $request->setNotificationId($notificationId);

        /* @var GetNotificationResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetNotification($request));
        $response->getNotification();
    }

    /**
     * Creates a subscriber to receive push notifications.
     *
     * @param $handler string
     * @param $handlerInstructions string[]
     * @return \Io\Token\Proto\Common\Subscriber\Subscriber
     * @throws Exception
     */
    public function subscribeToNotifications($handler, $handlerInstructions)
    {
        $request = new SubscribeToNotificationsRequest();
        $request->setHandler($handler);
        $request->setHandlerInstructions($handlerInstructions);

        /* @var $response SubscribeToNotificationsResponse */
        $response =  Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SubscribeToNotifications($request));
        return $response->getSubscriber();
    }

    /**
     * Gets a subscriber by Id.
     *
     * @param $subscriberId string
     * @return \Io\Token\Proto\Common\Subscriber\Subscriber
     * @throws Exception
     */
    public function getSubscriber($subscriberId)
    {
        $request = new GetSubscriberRequest();
        $request->setSubscriberId($subscriberId);

        /* @var $response GetSubscriberResponse */
        $response =  Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetSubscriber($request));
        return $response->getSubscriber();
    }

    /**
     * Gets all subscribers for the member.
     *
     * @return RepeatedField
     * @throws Exception
     */
    public function getSubscribers()
    {
        $request = new GetSubscribersRequest();

        /* @var $response GetSubscribersResponse */
        $response =  Util::executeAndHandleCall(self::gateway($this->authenticationContext())->GetSubscribers($request));
        return $response->getSubscribers();
    }
    /**
     * Sign with a Token signature a token request state payload.
     *
     * @param string $tokenRequestId token request id
     * @param string $tokenId token id
     * @param string $state state
     * @return Signature
     * @throws Exception
     */
    public function signTokenRequestState($tokenRequestId, $tokenId, $state)
    {
        $request = new SignTokenRequestStateRequest();
        $payload = new TokenRequestStatePayload();
        $payload->setTokenId($tokenId)
            ->setState($state);

        $request->setPayload($payload)
            ->setTokenRequestId($tokenRequestId);

        /** @var SignTokenRequestStateResponse $response */
        $response = Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SignTokenRequestState($request));
        return $response->getSignature();
    }


    /**
     * @param $callbackUrl string
     * @param $tokenRequestId string
     * @return string
     * @throws Exception
     */
    public function storeLinkingRequest($callbackUrl, $tokenRequestId)
    {
        $request = new StoreLinkingRequestRequest();
        $request->setCallbackUrl($callbackUrl);
        $request->setTokenRequestId($tokenRequestId);

        /** @var $response \Io\Token\Proto\Gateway\StoreLinkingRequestResponse */
        $response =Util::executeAndHandleCall(self::gateway($this->authenticationContext())->StoreLinkingRequest($request));
        return $response->getLinkingRequestId();
    }

    /**
     * @param $accountIds string[]
     * @return Message
     * @throws Exception
     */
    public function applySca($accountIds)
    {
        $request = new ApplyScaRequest();
        $request->setAccountId($accountIds);

        $response =Util::executeAndHandleCall(self::gateway($this->authenticationContext())->ApplySca($request));
        return $response;
    }

    /**
     * Sets the app's callback url.
     *
     * @param $appCallbackUrl string
     * @return Message
     * @throws Exception
     */
    public function setAppCallbackUrl($appCallbackUrl)
    {
        $request = new SetAppCallbackUrlRequest();
        $request->setAppCallbackUrl($appCallbackUrl);

        $response =Util::executeAndHandleCall(self::gateway($this->authenticationContext())->SetAppCallbackUrl($request));
        return $response;
    }

    /**
     * @param $tokenToCancel Token
     * @param $createToken CreateToken
     * @return TokenOperationResult
     * @throws Exception
     */
    public function cancelAndReplace($tokenToCancel, $createToken)
    {
        $signer = $this->cryptoEngine->createSigner(Key\Level::LOW);
        $signature = new Signature();
        $signature->setMemberId($this->memberId);
        $signature->setKeyId($signer->getKeyId());
        $act = $this->tokenAction($tokenToCancel->getPayload(), "CANCELLED" );
        $signature->setSignature($signer->signString($act));

        $cancelToken = new CancelToken();
        $cancelToken->setTokenId($tokenToCancel->getId());
        $cancelToken->setSignature($signature);

        $replaceRequest = new ReplaceTokenRequest();
        $replaceRequest->setCancelToken($cancelToken);
        $replaceRequest->setCreateToken($createToken);

        /* @var $response \Io\Token\Proto\Gateway\ReplaceTokenResponse */
        $response =Util::executeAndHandleCall(self::gateway($this->authenticationContext())->ReplaceToken($replaceRequest));
        return $response->getResult();
    }

}