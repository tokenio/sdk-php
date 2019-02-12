<?php

namespace Tokenio\Util;

class Base58
{
    /**
     * Encode a string into base58.
     *
     * @param string $string the string you wish to encode
     * @return string The Base58 encoded string
     * @throws \RuntimeException
     */
    public static function encode($string)
    {
        try {
            $base58 = new \StephenHill\Base58();
            return $base58->encode($string);
        } catch (\Exception $e) {
            throw new \RuntimeException("Cannot encode value as Base58.");
        }
    }
}
