<?php

namespace Tokenio\Exception;

use Tokenio\Exception;

class InvalidStateException extends Exception
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
