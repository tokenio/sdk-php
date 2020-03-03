<?php

namespace Tokenio\Security;

use Io\Token\Proto\Common\Security\Key;

interface CryptoEngineInterface
{
    /**
     * Generates keys of the specified level. If the key with the specified level
     * already exists, it is replaced. Old key is still kept around because it could be
     * used for signature verification later.
     *
     * @param int $level the key level
     * @return Key the generated key
     */
    public function generateKey($level);

    /**
     * Create a signer that signs data with the latest generated key of the specified level.
     *
     * @param int $level the key level
     * @return SignerInterface the signer
     */
    public function createSigner($level);

    /**
     * Create a verifier that verifies signatures with a specific key.
     *
     * @param string $keyId the key id
     * @return VerifierInterface the verifier
     */
    public function createVerifier($keyId);

    /**
     * Returns public keys that the CryptoEngine can use to sign.
     *
     * @return Key[] of public keys
     */
    public function getPublicKeys();
}
