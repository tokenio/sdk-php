<?php

namespace Tokenio\User\Rpc;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Blob\Blob;
use Io\Token\Proto\Common\Member\ReceiptContact;
use Io\Token\Proto\Common\Notification\AddKey;
use Io\Token\Proto\Common\Notification\NotifyBody;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Io\Token\Proto\Gateway\GetBlobRequest;
use Io\Token\Proto\Gateway\GetBlobResponse;
use Io\Token\Proto\Gateway\GetTokenRequestResultRequest;
use Io\Token\Proto\Gateway\GetTokenRequestResultResponse;
use Io\Token\Proto\Gateway\InvalidateNotificationRequest;
use Io\Token\Proto\Gateway\InvalidateNotificationResponse;
use Io\Token\Proto\Gateway\NotifyRequest;
use Io\Token\Proto\Gateway\NotifyResponse;
use Io\Token\Proto\Gateway\RequestTransferRequest;
use Io\Token\Proto\Gateway\RequestTransferResponse;
use Io\Token\Proto\Gateway\RetrieveTokenRequestRequest;
use Io\Token\Proto\Gateway\RetrieveTokenRequestResponse;
use Io\Token\Proto\Gateway\TriggerCreateAndEndorseTokenNotificationRequest;
use Io\Token\Proto\Gateway\TriggerCreateAndEndorseTokenNotificationResponse;
use Io\Token\Proto\Gateway\UpdateTokenRequestRequest;
use Io\Token\Proto\Gateway\UpdateTokenRequestResponse;
use Tokenio\TokenRequest;
use Tokenio\TokenRequest\TokenRequestResult;
use Tokenio\User\NotifyResult;
use Tokenio\User\Util\Util;

class UnauthenticatedClient extends \Tokenio\Rpc\UnauthenticatedClient
{
    public function __construct($gateway)
    {
        parent::__construct($gateway);
    }

    /**
     * Retrieves a blob from the server.
     *
     * @param $blobId string id of the blob
     * @return Blob
     */
    public function getBlob($blobId)
    {
        $request = new GetBlobRequest();
        $request->setBlobId($blobId);

        /* @var $response GetBlobResponse*/
        $response = Util::executeAndHandleCall($this->gateway->GetBlob($request));
        return $response->getBlob();
    }

    /**
     * Notifies subscribed devices that a key should be added.
     *
     * @param $alias Alias alias of the member
     * @param $addKey AddKey the add key payload to be sent
     * @return int
     */
    public function notifyAddKey($alias, $addKey)
    {
        $request = new NotifyRequest();
        $request->setAlias($alias);

        $notifyBody = new NotifyBody();
        $notifyBody->setAddKey($addKey);

        $request->setBody($notifyBody);

        /* @var $response NotifyResponse*/
        $response = Util::executeAndHandleCall($this->gateway->Notify($request));
        return $response->getStatus();
    }

    /**
     * Notifies subscribed devices of payment requests.
     *
     * @param $payload TokenPayload the payload of a token to be sent
     * @return int status of the notification request
     */
    public function notifyPaymentRequest($payload)
    {
        $request = new RequestTransferRequest();
        $request->setTokenPayload($payload);

        /* @var $response RequestTransferResponse */
        $response = Util::executeAndHandleCall($this->gateway->RequestTransfer($request));
        return $response->getStatus();
    }

    /**
     * Notifies subscribed devices that a token should be created and endorsed.
     *
     * @param $tokenRequestId string the token request ID to send
     * @param $addKey AddKey optional add key payload to send
     * @param $receiptContact ReceiptContact optional receipt contact to send
     * @return NotifyResult of the notification request
     */
    public function notifyCreateAndEndorseToken($tokenRequestId, $addKey=null, $receiptContact=null)
    {
        $request = new TriggerCreateAndEndorseTokenNotificationRequest();
        $request->setTokenRequestId($tokenRequestId);
        if($addKey !== null)
        {
            $request->setAddKey($addKey);
        }

        if($receiptContact !== null)
        {
            $request->setContact($receiptContact);
        }

        /* @var TriggerCreateAndEndorseTokenNotificationResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->TriggerCreateAndEndorseTokenNotification($request));
        return new NotifyResult($response->getNotificationId(), $response->getStatus());
    }

    /**
     * Invalidate a notification.
     *
     * @param $notificationId string
     * @return int
     */
    public function invalidateNotification($notificationId)
    {
        $request = new InvalidateNotificationRequest($notificationId);
        $request->setNotificationId($notificationId);

        /* @var InvalidateNotificationResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->InvalidateNotification($request));
        return $response->getStatus();
    }

    /**
     * Get the token request result based on a token's tokenRequestId.
     *
     * @param $tokenRequestId string  the token request id
     * @return TokenRequestResult
     */
    public function getTokenRequestResult($tokenRequestId)
    {
        $request = new GetTokenRequestResultRequest();
        $request->setTokenRequestId($tokenRequestId);

        /** @var GetTokenRequestResultResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTokenRequestResult($request));
        return new TokenRequestResult($response->getTokenId(), $response->getSignature());
    }

    /**
     * Retrieves a transfer token request.
     *
     * @param $tokenRequestId string the token request id
     *
     * @return TokenRequest the token request that was stored with the request id
     */
    public function retrieveTokenRequest($tokenRequestId)
    {
        $request = new RetrieveTokenRequestRequest();
        $request->setRequestId($tokenRequestId);

        /** @var RetrieveTokenRequestResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->RetrieveTokenRequest($request));
        return new TokenRequest($response->getTokenRequest()->getRequestPayload(), $response->getTokenRequest()->getRequestOptions());
    }

    /**
     * @param $requestId string
     * @param $options TokenRequestOptions
     * @return UpdateTokenRequestResponse
     */
    public function updateTokenRequest($requestId, $options)
    {
        $request = new UpdateTokenRequestRequest();
        $request->setRequestId($requestId);
        $request->setRequestOptions($options);

        /** @var UpdateTokenRequestResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->UpdateTokenRequest($request));
        return $response;
    }
}