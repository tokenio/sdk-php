<?php

namespace Tokenio\Security;

use Google\Protobuf\Internal\Message;
use Tokenio\Exception\CryptographicException;
use Tokenio\Util\Util;

class Ed25519Signer implements SignerInterface
{
    private $keyId;
    private $privateKey;

    /**
     * Construct the Ed25519Signer.
     *
     * @param string $keyId the key id
     * @param string $privateKey the private key
     */
    public function __construct($keyId, $privateKey)
    {
        $this->keyId = $keyId;
        $this->privateKey = $privateKey;
    }

    /**
     * Returns the Key ID used for signing.
     *
     * @return string The key id
     */
    public function getKeyId()
    {
        return $this->keyId;
    }

    /**
     * Signs protobuf message. The message is converted to normalized json and the json gets signed.
     *
     * @param Message $message the payload to sign
     * @return string the signature as a hex encoded string
     * @throws CryptographicException
     */
    public function sign($message)
    {
        $jsonMessage = Util::toJson($message);
        return $this->signString($jsonMessage);
    }

    /**
     * Signs protobuf message. The message is converted to normalized json and the json gets signed.
     *
     * @param string $message the payload to sign
     * @return string the signature as a hex encoded string
     * @throws CryptographicException
     */
    public function signString($message)
    {
        try {
            $message = stripcslashes($message);
            $signature = \ParagonIE_Sodium_Compat::crypto_sign_detached($message, $this->privateKey);
            return Base64Url::encode($signature);
        } catch (\Exception $e) {
            throw new CryptographicException("Cannot sign message.");
        }
    }
}
