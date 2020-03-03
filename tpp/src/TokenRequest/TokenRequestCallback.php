<?php

namespace Tokenio\Tpp\TokenRequest;

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
     * Get the token ID returned at the end of the Token Request Flow.
     *
     * @return string
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * Get the state returned at the end of the Token Request Flow. This corresponds to the state
     * set at the beginning of the flow.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
