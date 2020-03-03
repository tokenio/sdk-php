<?php

namespace Tokenio\User;

use Composer\Factory;
use Tokenio\Exception\StatusRuntimeException;
use Tokenio\Rpc\RpcChannelFactory;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Security\KeyStoreInterface;
use Tokenio\Security\TokenCryptoEngineFactory;
use Tokenio\TokenCluster;
use Tokenio\TokenEnvironment;

class TokenClientBuilder extends \Tokenio\TokenClientBuilder
{


    private $browserfactory;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sets the host name of the Token Gateway Service to connect to.
     *
     * @param $browserfactory
     * @return TokenClientBuilder
     */
    public function withBrowserfactory($browserfactory)
    {
        $this->browserfactory = $browserfactory;
        return $this;
    }

    /**
     * Builds and returns a new TokenIO instance.
     *
     * @return TokenClient
     * @throws \Exception
     */
    public function build()
    {
        $headers = self::getHeaders();

        $channel = RpcChannelFactory::createChannel($this->hostName, $this->port, $this->useSsl, $this->timeoutMs, $headers);
        $this->cryptoEngine = $this->cryptoEngine == null ? new TokenCryptoEngineFactory(new InMemoryKeyStore()) : $this->cryptoEngine;
        $this->tokenCluster = $this->tokenCluster == null ? TokenCluster::get(TokenEnvironment::SANDBOX) : $this->tokenCluster;

        return new TokenClient($channel, $this->cryptoEngine,  $this->tokenCluster, $this->browserfactory);
    }

    protected function getPlatform()
    {
        return 'php-user';
    }
}
