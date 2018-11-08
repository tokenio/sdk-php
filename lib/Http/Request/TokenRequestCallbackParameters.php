<?php

namespace Tokenio\Http\Request;

use Io\Token\Proto\Common\Security\Signature;
use Tokenio\Exception;

class TokenRequestCallbackParameters
{
    const TOKEN_ID_FIELD = 'tokenId';
    const STATE_FIELD = 'state';
    const SIGNATURE_FIELD = 'signature';

    /**
     * @var string
     */
    private $tokenId;

    /**
     * @var string
     */
    private $state;

    /**
     * @var Signature
     */
    private $signature;

    /**
     * @param string $callbackUrl
     * @return TokenRequestCallbackParameters
     * @throws Exception
     */
    public static function create($callbackUrl)
    {
        $parts = parse_url($callbackUrl);
        parse_str($parts['query'], $query);

        if (!isset($query[self::TOKEN_ID_FIELD], $query[self::STATE_FIELD], $query[self::SIGNATURE_FIELD])) {
            throw new Exception("Invalid or missing parameters in token request query.");
        }

        return new TokenRequestCallbackParameters($query[self::TOKEN_ID_FIELD], $query[self::STATE_FIELD], $query[self::SIGNATURE_FIELD]);
    }

    private function __construct($tokenId, $state, $signature)
    {
        $this->tokenId = $tokenId;
        $this->state = $state;
        $this->signature = json_decode($signature);
    }

    /**
     * @return string
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getSerializedState()
    {
        return $this->state;
    }

    /**
     * @return Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }
}