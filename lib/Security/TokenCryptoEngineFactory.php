<?php

namespace Tokenio\Security;

class TokenCryptoEngineFactory implements CryptoEngineFactoryInterface
{
    private $keyStore;

    /**
     * Construct the TokenCryptoEngineFactory.
     *
     * @param KeyStoreInterface $keyStore the key store
     */
    public function __construct($keyStore)
    {
        $this->keyStore = $keyStore;
    }

    /**
     * Creates a new CryptoEngineInterface for a given member.
     *
     * @param string $memberId the member id
     * @return CryptoEngineInterface the crypto engine instance
     */
    public function create($memberId)
    {
        return new TokenCryptoEngine($memberId, $this->keyStore);
    }
}
