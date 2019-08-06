<?php

namespace Io\Token\Util;

class Base58
{
    /**
     * Encode a string into base58.
     *
     * @param string $string the string you wish to encode
     * @return string The Base58 encoded string
     */
    public static function encode($string)
    {
        $base58 = new \StephenHill\Base58();
        return $base58->encode($string);
    }
}
