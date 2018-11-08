<?php

namespace Tokenio\Security;

interface CryptoEngineFactoryInterface
{
    /**
     * Creates a new CryptoEngineInterface for a given member.
     *
     * @param string $memberId the member id
     * @return CryptoEngineInterface the crypto engine instance
     */
    public function create($memberId);
}