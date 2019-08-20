<?php

namespace Io\Token\Exception;

class CryptoKeyNotFoundException extends \Exception
{
    /**
     * CryptoKeyNotFoundException constructor.
     *
     * @param string $keyId
     */
    public function __construct($keyId)
    {
        parent::__construct("Key not found: ${keyId}");
    }
}
