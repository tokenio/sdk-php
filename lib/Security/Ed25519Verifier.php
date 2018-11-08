<?php

namespace Tokenio\Security;

use Google\Protobuf\Internal\Message;
use Tokenio\Exception\CryptographicException;
use Tokenio\Util\Util;

class Ed25519Verifier implements VerifierInterface
{
    private $publicKey;

    /**
     * Construct the Ed25519Verifier.
     *
     * @param string $publicKey the public key
     */
    public function __construct($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * Verifies the protobuf payload signature.
     *
     * @param Message $message the payload to sign
     * @param string $signature the signature to verify
     * @return bool
     * @throws CryptographicException
     */
    public function verify($message, $signature)
    {
        $jsonMessage = Util::toJson($message);
        return $this->verifyString($jsonMessage, $signature);
    }

    /**
     * Verifies the protobuf payload signature.
     *
     * @param string $message the payload to sign
     * @param string $signature the signature to verify
     * @return bool
     * @throws CryptographicException
     */
    public function verifyString($message, $signature)
    {
        try {
            $signature = Base64Url::decode($signature);
            $verified = \ParagonIE_Sodium_Compat::crypto_sign_verify_detached($signature, $message, $this->publicKey);
        } catch (\Exception $e) {
            throw new CryptographicException("Cannot to verify signature.");
        }

        if (!$verified) {
            throw new CryptographicException("Failed to verify signature.");
        }

        return $verified;
    }
}