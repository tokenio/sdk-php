<?php

namespace Tokenio\Http\Request;

/**
 * Represents callback in Token Request Flow. Contains tokenID and state.
 */
class TokenRequestCallback
{
    /**
     * @var string
     */
    private $tokenId;

    /**
     * @var string
     */
    private $state;

    public function __construct($tokenId, $state)
    {
        $this->tokenId = $tokenId;
        $this->state = $state;
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
    public function getState()
    {
        return $this->state;
    }
}
