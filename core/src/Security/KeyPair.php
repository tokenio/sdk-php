<?php

namespace Tokenio\Security;

use Exception;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Key\Algorithm;
use JsonSerializable;
use ParagonIE_Sodium_Compat;
use Tokenio\Exception\CryptographicException;
use Tokenio\Util\Base64Url;

class KeyPair implements JsonSerializable
{
    private $id;
    private $level;
    private $algorithm;
    private $privateKey;
    private $publicKey;
    private $expiresAtMs;

    /**
     * Construct the KeyPair.
     *
     * @param string $id
     * @param int $level
     * @param int $algorithm
     * @param string $privateKey
     * @param string $publicKey
     * @param int $expiresAtMs
     */
    public function __construct($id, $level, $algorithm, $privateKey, $publicKey, $expiresAtMs = 0)
    {
        $this->id = $id;
        $this->level = $level;
        $this->algorithm = $algorithm;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->expiresAtMs = $expiresAtMs;
    }

    /**
     * Creates a new key pair.
     *
     * @param int $level the level of the key pair
     * @param int $expiresAtMs
     * @return KeyPair the key pair
     * @throws CryptographicException
     */
    public static function generate($level, $expiresAtMs = 0)
    {
        try {
            $sodiumKeyPair = ParagonIE_Sodium_Compat::crypto_sign_keypair();

            $privateKey = ParagonIE_Sodium_Compat::crypto_sign_secretkey($sodiumKeyPair);
            $publicKey = ParagonIE_Sodium_Compat::crypto_sign_publickey($sodiumKeyPair);

            $id = substr(Base64Url::encode(hash('sha256', $publicKey, true)), 0, 16);
            return new KeyPair($id, $level, Algorithm::ED25519, $privateKey, $publicKey, $expiresAtMs);
        } catch (Exception $e) {
            throw new CryptographicException("Cannot generate a new key pair.");
        }
    }

    public static function fromJson($data)
    {
        return new KeyPair(
            $data['id'],
            $data['level'],
            $data['algorithm'],
            base64_decode($data['privateKey']),
            base64_decode($data['publicKey']),
            $data['expiresAtMs']
        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getExpiresAtMs()
    {
        return $this->expiresAtMs;
    }

    /**
     * Construct the Key from current KeyPair.
     *
     * @return Key
     */
    public function toKey()
    {
        $key = new Key();
        $key->setId($this->id);
        $key->setLevel($this->level);
        $key->setAlgorithm($this->algorithm);
        $key->setPublicKey(Base64Url::encode($this->publicKey));
        $key->setExpiresAtMs($this->expiresAtMs);

        return $key;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        $vars['privateKey'] = base64_encode($this->privateKey);
        $vars['publicKey'] = base64_encode($this->publicKey);

        return $vars;
    }

    public function isExpired()
    {
        $milliseconds = round(microtime(true) * 1000);
        return $this->expiresAtMs != null && $this->expiresAtMs < $milliseconds;
    }
}
