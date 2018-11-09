<?php

namespace Tokenio\Security;

use Google\Protobuf\Internal\Message;

interface VerifierInterface
{
    /**
     * Verifies the protobuf payload signature.
     *
     * @param Message $message the payload to sign
     * @param string $signature the signature to verify
     * @return bool
     */
    public function verify($message, $signature);

    /**
     * Verifies the protobuf payload signature.
     *
     * @param string $message the payload to sign
     * @param string $signature the signature to verify
     * @return bool
     */
    public function verifyString($message, $signature);
}
