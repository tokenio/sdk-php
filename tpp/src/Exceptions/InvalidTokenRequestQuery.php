<?php

namespace Tokenio\Tpp\Exception;

class InvalidTokenRequestQuery extends \RuntimeException
{
    /**
     * InvalidTokenRequestQuery constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("Invalid or missing parameters in token request query.");
    }
}
