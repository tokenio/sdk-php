<?php

namespace Io\Token\Security;

use Google\Protobuf\Internal\Message;

interface SignerInterface
{
    /**
     * Returns the Key ID used for signing.
     *
     * @return string The key id
     */
    public function getKeyId();

    /**
     * Signs protobuf message. The message is converted to normalized json and the json gets signed.
     *
     * @param Message $message the payload to sign
     * @return string the signature as a hex encoded string
     */
    public function sign($message);

    /**
     * Signs protobuf message. The message is converted to normalized json and the json gets signed.
     *
     * @param string $message the payload to sign
     * @return string the signature as a hex encoded string
     */
    public function signString($message);
}
