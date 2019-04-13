<?php

namespace Tokenio;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\ActingAs;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use \Io\Token\Proto\Common\Token\TokenRequestOptions;
use Tokenio\Util\Util;

class TokenRequestBuilder
{
    /**
     * @deprecated
     * @var TokenPayload
     */
    private $tokenPayload;

    /**
     * @deprecated
     * @var string[]
     */
    private $options;

    /**
     * @deprecated
     * @var string
     */
    private $userRefId;

    /**
     * @deprecated
     * @var string
     */
    private $customizationId;

    /**
     * @var TokenRequestPayload
     */
    protected $requestPayload;

    /**
     * @var \Io\Token\Proto\Common\Token\TokenRequestOptions
     */
    protected $requestOptions;

    /**
     * @var string
     */
    protected $oauthState;

    /**
     * @var string
     */
    protected $csrfToken;

    /**
     * TokenRequestBuilder constructor.
     * @param TokenPayload $tokenPayload
     */
    public function __construct($tokenPayload)
    {
        $this->tokenPayload = $tokenPayload;
        $this->options = array();
        $this->requestPayload = new TokenRequestPayload();
        $this->requestOptions = new TokenRequestOptions();
        $this->requestPayload->setTo(new TokenMember());
        $this->requestOptions->setFrom(new TokenMember());
    }

    /**
     * Optional. Sets the bank ID in order to bypass the Token bank selection UI.
     *
     * @param string bankId bank ID
     * @return $this
     */
    public function setBankId($bankId)
    {
        $this->requestOptions->setBankId($bankId);
        return $this;
    }

    /**
     * Optional. Sets the payer/grantor member ID in order to bypass the Token email input UI.
     *
     * @param string romMemberId payer/grantor member ID
     * @return $this
     */
    public function setFromMemberId($memberId)
    {
        $this->requestOptions->getFrom()->setId($memberId);
        return $this;
    }

    /**
     * Optional. Sets the payer/grantor alias in order to bypass the Token email input UI.
     *
     * @param Alias fromAlias payer/grantor alias
     * @return $this
     */
    public function setFromAlias($fromAlias)
    {
        $this->requestOptions->getFrom()->setAlias($fromAlias);
        return $this;
    }

    /**
     * Optional. Sets the account ID of the source bank account.
     *
     * @param string sourceAccountId source bank account ID
     * @return $this
     */
    public function setSourceAccount($sourceAccountId)
    {
        $this->requestOptions->setSourceAccountId($sourceAccountId);
        return $this;
    }

    /**
     * Optional. True if a receipt should be sent to the payee/grantee's default
     * receipt email/SMS/etc.
     *
     * @param bool receipt requested flag
     * @return $this
     */
    public function setReceiptRequest($receiptRequested)
    {
        $this->requestOptions->setReceiptRequested($receiptRequested);
        return $this;
    }

    /**
     * Optional. Sets the ID used to track a member claimed by a TPP.
     *
     * @param string userRefId user ref ID
     * @return $this
     */
    public function setUserRefId($userRefId)
    {
        $this->userRefId = $userRefId;
        $this->requestPayload->setUserRefId($userRefId);
        return $this;
    }

    /**
     * Optional. Sets the ID used to customize the UI of the web-app.
     *
     * @param string customization ID
     * @return $this
     */
    public function setCustomizationId($customizationId)
    {
        $this->customizationId = $customizationId;
        $this->requestPayload->setCustomizationId($customizationId);
        return $this;
    }

    /**
     * Sets the callback URL to the server that will initiate redemption of the token.
     *
     * @param string redirectUrl redirect URL
     * @return $this
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->requestPayload->setRedirectUrl($redirectUrl);
        return $this;
    }

    /**
     * Sets the reference ID of the token.
     *
     * @param string refId token ref ID
     * @return $this
     */
    public function setRefId($refId)
    {
        $this->requestPayload->setRefId($refId);
        return $this;
    }

    /**
     * Sets the alias of the payee/grantee.
     *
     * @param Alias toAlias alias
     * @return $this
     */
    public function setToAlias($toAlias)
    {
        $this->requestPayload->getTo()->setAlias($toAlias);
        return $this;
    }

    /**
     * Sets the memberId of the payee/grantee.
     *
     * @param string toMemberId memberId
     * @return $this
     */
    public function setToMemberId($toMemberId)
    {
        $this->requestPayload->getTo()->setId($toMemberId);
        return $this;
    }

    /**
     * Sets acting as on the token.
     *
     * @param ActingAs actingAs entity the redeemer is acting on behalf of
     * @return $this
     */
    public function setActingAs($actingAs)
    {
        $this->requestPayload->setActingAs($actingAs);
        return $this;
    }

    /**
     * Sets the description.
     *
     * @param string description description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->requestPayload->setDescription($description);
        return $this;
    }

    /**
     * Sets a developer-specified string that allows state to be persisted
     * between the the request and callback phases of the flow.
     *
     * @param string state state
     * @return $this
     */
    public function setState($state){
        $this->oauthState = $state;
        return $this;
    }

    /**
     * A nonce that will be verified in the callback phase of the flow.
     * Used for CSRF attack mitigation.
     *
     * @param string csrfToken CSRF token
     * @return $this
     */
    public function setCsrfToken($csrfToken)
    {
        $this->csrfToken = $csrfToken;
        return $this;
    }

    /**
     * @deprecated
     * @param string $option
     * @param string $value
     * @return $this
     */
    public function addOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * @deprecated
     * @param array $options
     * @return $this
     */
    public function addAllOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * Builds the token payload.
     *
     * @return TokenRequest instance
     */
    public function build()
    {
        $serializeState = new TokenRequestState(
            $this->csrfToken == null ? "" : Util::hashString($this->csrfToken),
            $this->oauthState);

        $this->requestPayload->setCallbackState($serializeState->serialize());

        return new TokenRequest(
            $this->tokenPayload,
            $this->options,
            $this->userRefId,
            $this->customizationId,
            $this->requestPayload,
            $this->requestOptions);
    }
}
