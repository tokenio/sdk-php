<?php

namespace Tokenio\Security;

use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Key\Algorithm;
use Tokenio\Exception\CryptographicException;

class KeyPair implements \JsonSerializable
{
    private $id;
    private $level;
    private $algorithm;
    private $privateKey;
    private $publicKey;

    /**
     * Creates a new key pair.
     *
     * @param int $level the level of the key pair
     * @return KeyPair the key pair
     * @throws CryptographicException
     */
    public static function generate($level)
    {
        try {
            $sodiumKeyPair = \ParagonIE_Sodium_Compat::crypto_sign_keypair();

            $privateKey = \ParagonIE_Sodium_Compat::crypto_sign_secretkey($sodiumKeyPair);
            $publicKey = \ParagonIE_Sodium_Compat::crypto_sign_publickey($sodiumKeyPair);

            $id = substr(Base64Url::encode(hash('sha256', $publicKey, true)), 0, 16);
            return new KeyPair($id, $level, Algorithm::ED25519, $privateKey, $publicKey);
        } catch (\Exception $e) {
            throw new CryptographicException("Cannot generate a new key pair.");
        }
    }

    /**
     * Construct the KeyPair.
     *
     * @param string $id
     * @param int $level
     * @param int $algorithm
     * @param string $privateKey
     * @param string $publicKey
     */
    public function __construct($id, $level, $algorithm, $privateKey, $publicKey)
    {
        $this->id = $id;
        $this->level = $level;
        $this->algorithm = $algorithm;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
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

        return $key;
    }

    public static function fromJson($data)
    {
        return new KeyPair(
            $data['id'],
            $data['level'],
            $data['algorithm'],
            base64_decode($data['privateKey']),
            base64_decode($data['publicKey'])
        );
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        $vars['privateKey'] = base64_encode($this->privateKey);
        $vars['publicKey'] = base64_encode($this->publicKey);

        return $vars;
    }
}
