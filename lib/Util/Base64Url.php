<?php

namespace Io\Token\Util;

/**
 * Encode and decode data into Base64 Url Safe.
 */
final class Base64Url
{
    /**
     * @param string $data the data to encode
     * @param bool $usePadding if true, the "=" padding at end of the encoded value are kept, else it is removed
     *
     * @return string the data encoded
     */
    public static function encode($data, $usePadding = false)
    {
        $encoded = strtr(base64_encode($data), '+/', '-_');

        return true === $usePadding ? $encoded : rtrim($encoded, '=');
    }

    /**
     * @param string $data the data to decode
     *
     * @return string the data decoded
     * @throws \InvalidArgumentException
     */
    public static function decode($data)
    {
        $decoded = base64_decode(strtr($data, '-_', '+/'), true);
        if ($decoded === false) {
            throw new \InvalidArgumentException('Cannot decode Base64, invalid data provided.');
        }

        return $decoded;
    }
}
