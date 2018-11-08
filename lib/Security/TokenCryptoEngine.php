<?php

namespace Tokenio\Security;

use Io\Token\Proto\Common\Security\Key;

class TokenCryptoEngine implements CryptoEngineInterface
{
    private $memberId;
    private $keyStore;

    /**
     * Construct the TokenCryptoEngine.
     *
     * @param string $memberId the the member id
     * @param KeyStoreInterface $keyStore the key store
     */
    public function __construct($memberId, $keyStore)
    {
        $this->memberId = $memberId;
        $this->keyStore = $keyStore;
    }

    /**
     * Generates keys of the specified level. If the key with the specified level
     * already exists, it is replaced. Old key is still kept around because it could be
     * used for signature verification later.
     *
     * @param int $level the key level
     * @return Key the generated key
     * @throws \Tokenio\Exception\CryptographicException
     */
    public function generateKey($level)
    {
        $keyPair = KeyPair::generate($level);
        $this->keyStore->put($this->memberId, $keyPair);

        return $keyPair->toKey();
    }

    /**
     * Create a signer that signs data with the latest generated key of the specified level.
     *
     * @param int $level the key level
     * @return SignerInterface the signer
     */
    public function createSigner($level)
    {
        $keyPair = $this->keyStore->getByLevel($this->memberId, $level);
        return new Ed25519Signer($keyPair->getId(), $keyPair->getPrivateKey());
    }

    /**
     * Create a verifier that verifies signatures with a specific key.
     *
     * @param string $keyId the key id
     * @return VerifierInterface the verifier
     */
    public function createVerifier($keyId)
    {
        $keyPair = $this->keyStore->getById($this->memberId, $keyId);
        return new Ed25519Verifier($keyPair->getPublicKey());
    }
}