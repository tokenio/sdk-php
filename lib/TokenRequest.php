<?php

namespace Tokenio;

use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody\ResourceType;

class TokenRequest
{
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
     * @param TokenRequestPayload $tokenRequestPayload
     * @param TokenRequestOptions $tokenRequestOptions
     */
    public function __construct($tokenRequestPayload = null, $tokenRequestOptions = null)
    {
        $this->tokenRequestPayload = $tokenRequestPayload;
        $this->tokenRequestOptions = $tokenRequestOptions;
    }

    public static function fromProtos($tokenRequestPayload, $tokenRequestOptions)
    {
        return new TokenRequest($tokenRequestPayload, $tokenRequestOptions);
    }

    /**
     * Create a new Builder instance for an access token request.
     *
     * @param ResourceType[] $resources
     * @return AccessTokenRequestBuilder
     */
    public static function accessTokenRequestBuilder($resources)
    {
        return new AccessTokenRequestBuilder($resources);
    }

    /**
     * Create a new Builder instance for a transfer token request.
     *
     * @param string $amount
     * @param string $currency
     * @return TransferTokenRequestBuilder
     */
    public static function transferTokenRequestBuilder($amount, $currency)
    {
        return new TransferTokenRequestBuilder($amount, $currency);
    }

    /**
     * @return TokenRequestPayload|null
     */
    public function getTokenRequestPayload()
    {
        return $this->tokenRequestPayload;
    }

    /**
     * @return TokenRequestOptions|null
     */
    public function getTokenRequestOptions()
    {
        return $this->tokenRequestOptions;
    }
}
