<?php

namespace Tokenio;

use Google\Protobuf\Internal\MapField;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequestPayload;

class TokenRequest
{
    /**
     * @deprecated
     * @var TokenPayload
     *
     */
    private $tokenPayload;

    /**
     * @deprecated
     * @var MapField
     *
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
     * @var \Io\Token\Proto\Common\Token\TokenRequestPayload
     */
    private $tokenRequestPayload;

    /**
     * @var \Io\Token\Proto\Common\Token\TokenRequestOptions
     */
    private $tokenRequestOptions;

    /**
     * TokenRequest constructor.
     *
     * @param TokenPayload $tokenPayload
     * @param string[] $options
     * @param string $userRefId
     * @param string $customizationId
     * @param TokenRequestPayload $tokenReqPayload
     * @param \Io\Token\Proto\Common\Token\TokenRequestOptions $tokenReqOptions
     */
    public function __construct($tokenPayload, $options, $userRefId, $customizationId,
                                $tokenRequestPayload = null, $tokenRequestOptions = null)
    {
        $this->tokenPayload = $tokenPayload;
        $this->options = $options;
        $this->userRefId = $userRefId;
        $this->customizationId = $customizationId;
        $this->tokenRequestPayload = $tokenRequestPayload;
        $this->tokenRequestOptions = $tokenRequestOptions;
    }

    public static function fromProtos($tokenRequestPayload, $tokenRequestOptions)
    {
        return new TokenRequest(
            null,
            array(),
            "",
            "",
            $tokenRequestPayload,
            $tokenRequestOptions);
    }

    /**
     * @param TokenRequestPayload\AccessBody\ResourceType[] $resources
     * @return AccessTokenRequestBuilder
     */
    public static function accessTokenRequestBuilder($resources)
    {
        return new AccessTokenRequestBuilder($resources);
    }

    public static function transferTokenRequestBuilder($amount, $currency)
    {
        return new TransferTokenRequestBuilder($amount, $currency);
    }

    /**
     * @deprecated
     * @return TokenPayload
     */
    public function getTokenPayload()
    {
        return $this->tokenPayload;
    }

    /**
     * @deprecated
     * @return MapField
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getUserRefId()
    {
        return $this->userRefId;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getCustomizationId()
    {
        return $this->customizationId;
    }

    /**
     * @return TokenRequestPayload|null
     */
    public function getTokenRequestPayload()
    {
        return $this->tokenRequestPayload;
    }

    /**
     * @return \Io\Token\Proto\Common\Token\TokenRequestOptions|null
     */
    public function getTokenRequestOptions()
    {
        return $this->tokenRequestOptions;
    }


    /**
     * @deprecated
     * @param TokenPayload $tokenPayload
     * @return TokenRequestBuilder
     */
    public static function builder($tokenPayload)
    {
        return new TokenRequestBuilder($tokenPayload);
    }
}
