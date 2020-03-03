<?php

namespace Tokenio\Tpp\Exception;

class InvalidStateException extends \RuntimeException
{
    /**
     * InvalidStateException constructor.
     *
     * @param string $csrfToken
     */
    public function __construct($csrfToken)
    {
        parent::__construct("CSRF token ${csrfToken} does not match CSRF token in state (hashed)");
    }
}
