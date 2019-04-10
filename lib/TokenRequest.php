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
     * @var TokenRequestPayload
     */
    private $tokenRequestPayload;

    /**
     * @var TokenRequestOptions
     */
    private $tokenRequestOptions;

    /**
     * TokenRequest constructor.
     *
     * @param TokenPayload $tokenPayload
     * @param string[] $options
     * @param string $userRefId
     * @param string $customizationId
     */
    public function __construct($tokenPayload, $options, $userRefId, $customizationId,
                                $tokanReqPayload = null, $tokenReqOptions = null)
    {
        $this->tokenPayload = $tokenPayload;
        $this->options = $options;
        $this->userRefId = $userRefId;
        $this->customizationId = $customizationId;
        $this->tokenRequestPayload = $tokanReqPayload;
        $this->tokenRequestOptions = $tokenReqOptions;
    }

    public static function fromProtos($payload, $options ){
        return new TokenRequest(null, null, null, null,
            $payload, $options);
    }

    public static function accessTokenRequestBuilder(...$resources)
    {
        return new AccessBuilder($resources);
    }

    public static function transferTokenRequestBuilder($amount, $currency)
    {
        return new TransferBuilder($amount, $currency);
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
     * @deprecated
     * @param TokenPayload $tokenPayload
     * @return TokenRequestBuilder
     */
    public static function builder($tokenPayload)
    {
        return new TokenRequestBuilder($tokenPayload);
    }
}
