<?php

namespace Tokenio;

use Io\Token\Proto\Common\Security\Signature;

class TokenRequestResult
{
    /**
     * @var string
     */
    private $tokenId;

    /**
     * @var Signature
     */
    private $signature;

    /**
     * TokenRequestResult constructor.
     *
     * @param string $tokenId
     * @param Signature $signature
     */
    public function __construct($tokenId, Signature $signature)
    {
        $this->tokenId = $tokenId;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * @return Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
