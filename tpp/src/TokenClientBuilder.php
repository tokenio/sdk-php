<?php


namespace Tokenio\Tpp;

use Tokenio\Rpc\RpcChannelFactory;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Security\TokenCryptoEngineFactory;
use Tokenio\TokenCluster;
use Tokenio\TokenEnvironment;

class TokenClientBuilder extends \Tokenio\TokenClientBuilder
{
    public function __construct()
    {
            parent::__construct();
    }

    /**
     * @return TokenClient
     * @throws \Exception
     */
    public function build()
    {
        $headers = self::getHeaders();
        $channel = RpcChannelFactory::createChannel($this->hostName, $this->port, $this->useSsl, $this->timeoutMs, $headers);
        $this->cryptoEngine = $this->cryptoEngine == null ? new TokenCryptoEngineFactory(new InMemoryKeyStore()) : $this->cryptoEngine;
        $this->tokenCluster = $this->tokenCluster == null ? TokenCluster::get(TokenEnvironment::SANDBOX) : $this->tokenCluster;

        return new TokenClient($channel, $this->cryptoEngine, $this->tokenCluster);
    }

    /**
     * @return string
     */
    protected function getPlatform()
    {
        return "php-tpp";
    }
}