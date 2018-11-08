<?php

namespace Tokenio\Security;

use Tokenio\Exception;

class Base58
{
    /**
     * Encode a string into base58.
     *
     * @param string $string the string you wish to encode
     * @return string The Base58 encoded string
     * @throws Exception\CryptographicException
     */
    public static function encode($string)
    {
        try {
            $base58 = new \StephenHill\Base58();
            return $base58->encode($string);
        } catch (\Exception $e) {
            throw new Exception\CryptographicException("Cannot encode value as Base58.");
        }
    }
}