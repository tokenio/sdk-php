<?php

namespace Tokenio\Exception;

class BankAuthorizationRequiredException extends \RuntimeException
{
    /**
     * CryptoKeyNotFoundException constructor.
     *
     */
    public function __construct()
    {
        parent::__construct("Must call linkAccounts with bank authorization payload.");
    }
}
