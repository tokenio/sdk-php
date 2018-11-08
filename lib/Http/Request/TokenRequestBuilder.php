<?php

namespace Tokenio\Http\Request;

use Io\Token\Proto\Common\Token\TokenPayload;

class TokenRequestBuilder
{
    /**
     * @var TokenPayload
     */
    private $tokenPayload;

    /**
     * @var string[]
     */
    private $options;

    /**
     * @var string
     */
    private $userRefId;

    /**
     * @var string
     */
    private $customizationId;

    /**
     * TokenRequestBuilder constructor.
     * @param TokenPayload $tokenPayload
     */
    public function __construct($tokenPayload)
    {
        $this->tokenPayload = $tokenPayload;
        $this->options = array();
    }

    /**
     * @param string $option
     * @param string $value
     * @return TokenRequestBuilder
     */
    public function addOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * @param array $options
     * @return TokenRequestBuilder
     */
    public function addAllOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @param string $userRefId
     * @return TokenRequestBuilder
     */
    public function setUserRefId($userRefId)
    {
        $this->userRefId = $userRefId;
        return $this;
    }

    /**
     * @param string $customizationId
     * @return TokenRequestBuilder
     */
    public function setCustomizationId($customizationId)
    {
        $this->customizationId = $customizationId;
        return $this;
    }

    /**
     * @return TokenRequest
     */
    public function build()
    {
        return new TokenRequest($this->tokenPayload, $this->options, $this->userRefId, $this->customizationId);
    }
}