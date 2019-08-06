<?php

namespace Io\Token\Util;

abstract class Strings
{
    /**
     * Check if sting is null or empty
     *
     * @param $str
     * @return bool
     */
    public static function isEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    /**
     * Generate Nonce
     *
     * @return string
     */
    public static function generateNonce()
    {
        return self::generateRandomString(18);
    }

    /**
     * Generate secured random string
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 10)
    {
        $pattern = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        try {
            $pieces = [];
            $max = strlen($pattern) - 1;

            for ($i = 0; $i < $length; ++$i) {
                $pieces [] = $pattern[random_int(0, $max)];
            }

            return implode('', $pieces);
        } catch (\Exception $e) {
            return substr(str_shuffle(str_repeat($pattern, ceil($length / strlen($pattern)))), 1, $length);
        }
    }
}
