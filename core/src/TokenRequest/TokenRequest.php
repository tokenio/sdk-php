<?php

namespace Tokenio;

use Io\Token\Proto\Common\Token\TokenRequestOptions;
use Io\Token\Proto\Common\Token\TokenRequestPayload;
use PHPUnit\Runner\Exception;
use ReflectionException;
use Tokenio\TokenRequest\Builder\AccessBuilder;
use TokenRequestPayload\AccessBody\AccountResourceList\AccountResource;

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
        if($tokenRequestPayload === null)
        {
            throw new Exception("Null tokenRequestPayload");
        }
        $this->tokenRequestPayload = $tokenRequestPayload;

        if($tokenRequestOptions === null)
        {
            throw new Exception("Null tokenRequestOptions");
        }
        $this->tokenRequestOptions = $tokenRequestOptions;
    }

    /**
     * @param $tokenRequestPayload
     * @param $tokenRequestOptions
     * @return TokenRequest
     */
    public static function fromProtos($tokenRequestPayload, $tokenRequestOptions)
    {
        return new TokenRequest($tokenRequestPayload, $tokenRequestOptions);
    }

    /**
     * Create a new Builder instance for an access token request.
     *
     * @param int[] $resources
     * @param TokenRequestPayload\AccessBody\AccountResourceList $list
     * @return AccessBuilder
     * @throws ReflectionException
     */
    public static function accessTokenRequestBuilder($resources = null, $list = null)
    {
        return new AccessBuilder($resources, $list);
    }

    /**
     * Create a new Builder instance for a transfer token request.
     *
     * @param double $amount
     * @param string $currency
     * @return TransferBuilder
     */
    public static function transferTokenRequestBuilder($amount, $currency)
    {
        return new TransferBuilder($amount, $currency);
    }

    /**
     * @return TokenRequestPayload|null
     */
    public function getTokenRequestPayload()
    {
        return $this->tokenRequestPayload;
    }

    /**
     * @return TokenRequestOptions
     */
    public function getTokenRequestOptions()
    {
        return $this->tokenRequestOptions;
    }
}