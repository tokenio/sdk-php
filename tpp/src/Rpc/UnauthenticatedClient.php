<?php

namespace Tokenio\Tpp\Rpc;

use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Proto\Gateway\GetMemberRequest;
use Io\Token\Proto\Gateway\GetMemberResponse;
use Io\Token\Proto\Gateway\GetTokenRequestResultRequest;
use Io\Token\Proto\Gateway\GetTokenRequestResultResponse;
use Io\Token\Proto\Gateway\RetrieveTokenRequestRequest;
use Io\Token\Proto\Gateway\RetrieveTokenRequestResponse;
use \Tokenio;
use Tokenio\Util\Util;

class UnauthenticatedClient extends \Tokenio\Rpc\UnauthenticatedClient
{
    /**
     * UnauthenticatedClient constructor.
     * @param GatewayServiceClient $gateway
     */
    public function __construct($gateway)
    {
        parent::__construct($gateway);
    }

    /**
     * Looks up member information for the given member ID. The user is defined by
     * the key used for authentication.
     *
     * @param string $memberId
     * @return Member
     */
    public function getMember($memberId)
    {
        $memberRequest = new GetMemberRequest();
        $memberRequest->setMemberId($memberId);

        /** @var GetMemberResponse $response */
        $response = Util::executeAndHandleCall($this->gateway->GetMember($memberRequest));

        return $response->getMember();
    }

    /**
     * Return the token member.
     *
     * @return Member
     */
    public function getTokenMember(){
        $memberId = $this->getMemberId(Util::getToken());
        return $this->getMember($memberId);
    }

    /**
     * Get the token request result based on a token's tokenRequestId.
     *
     * @param string $tokenRequestId token request id
     * @return Tokenio\TokenRequest\TokenRequestResult
     */
    public function getTokenRequestResult($tokenRequestId)
    {
        $tokenRequest = new GetTokenRequestResultRequest();
        $tokenRequest->setTokenRequestId($tokenRequestId);

        /** @var GetTokenRequestResultResponse $response $response */
        $response = Util::executeAndHandleCall($this->gateway->GetTokenRequestResult($tokenRequest));

        return new Tokenio\TokenRequest\TokenRequestResult($response->getTokenId(), $response->getSignature());
    }

    /**
     * Retrieves a transfer token request.
     *
     * @param string $tokenRequestId token request id
     * @return Tokenio\TokenRequest token request that was stored with the request id
     */
    public function retrieveTokenRequest($tokenRequestId)
    {
        $tokenRequest = new RetrieveTokenRequestRequest();
        $tokenRequest->setRequestId($tokenRequestId);

        /** @var RetrieveTokenRequestResponse $response $response */
        $response = Util::executeAndHandleCall($this->gateway->RetrieveTokenRequest($tokenRequest));

        return Tokenio\TokenRequest::fromProtos($response->getTokenRequest()->getRequestPayload(), $response->getTokenRequest()->getRequestOptions());
    }
}