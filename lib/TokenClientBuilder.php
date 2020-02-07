<?php

namespace Tokenio;

use Composer\Factory;
use Tokenio\Rpc\RpcChannelFactory;
use Tokenio\RuntimeException;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\KeyStoreInterface;
use Tokenio\Security\TokenCryptoEngineFactory;
use Tokenio\TokenIO;

class TokenClientBuilder
{
    const DEFAULT_DEV_KEY = "4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI";
    const DEFAULT_TIMEOUT_MS = 10000;
    const DEFAULT_SSL_PORT = 443;

    /**
     * @var int
     */
    private $port;

    /**
     * @var bool
     */
    private $useSsl;

    /**
     * @var TokenCluster
     */
    private $tokenCluster;

    /**
     * @var string
     */
    private $hostName;

    /**
     * @var int
     */
    private $timeoutMs;

    /**
     * @var CryptoEngineFactoryInterface
     */
    private $cryptoEngine;

    /**
     * @var string
     */
    private $devKey;

    public function __construct()
    {
        $this->devKey = self::DEFAULT_DEV_KEY;
        $this->port = self::DEFAULT_SSL_PORT;
        $this->timeoutMs = self::DEFAULT_TIMEOUT_MS;
        $this->useSsl = true;
    }

    /**
     * Sets the host name of the Token Gateway Service to connect to.
     *
     * @param string $hostName the host name to set
     * @return TokenClientBuilder
     */
    public function hostName($hostName)
    {
        $this->hostName = $hostName;
        return $this;
    }

    /**
     * Sets the port of the Token Gateway Service to connect to.
     *
     * @param int $port the port number
     * @return TokenClientBuilder
     */
    public function port($port)
    {
        $this->port = $port;
        $this->useSsl = $port == self::DEFAULT_SSL_PORT;
        return $this;
    }

    /**
     * Sets Token cluster to connect to.
     *
     * @param TokenCluster $cluster the token cluster
     * @return TokenClientBuilder
     */
    public function connectTo($cluster)
    {
        $this->tokenCluster = $cluster;
        $this->hostName = $cluster->getUrl();

        return $this;
    }

    /**
     * Sets timeoutMs that is used for the RPC calls.
     *
     * @param int $timeoutMs the RPC call timeoutMs
     * @return TokenClientBuilder
     */
    public function timeout($timeoutMs)
    {
        $this->timeoutMs = $timeoutMs;
        return $this;
    }

    /**
     * Sets the keystore to be used with the SDK.
     *
     * @param KeyStoreInterface $keyStore the key store to be used
     * @return TokenClientBuilder
     */
    public function withKeyStore($keyStore)
    {
        $this->cryptoEngine = new TokenCryptoEngineFactory($keyStore);
        return $this;
    }

    /**
     * Sets the crypto engine to be used with the SDK.
     *
     * @param CryptoEngineFactoryInterface $cryptoEngineFactory
     * @return TokenClientBuilder
     */
    public function withCryptoEngine($cryptoEngineFactory)
    {
        $this->cryptoEngine = $cryptoEngineFactory;
        return $this;
    }

    /**
     * Sets the developer key to be used with the SDK.
     *
     * @param string $devKey
     * @return TokenClientBuilder
     */
    public function developerKey($devKey)
    {
        $this->devKey = $devKey;
        return $this;
    }

    /**
     * Builds and returns a new TokenIO instance.
     *
     * @return TokenClient
     */
    public function build()
    {
        $composerFilePath = Factory::getComposerFile();

        if($composerFilePath == './composer.json'){
            $composerFilePath = realpath(__DIR__ . '/..') . '/composer.json';
        }

        $composerJson = json_decode(file_get_contents($composerFilePath), true);
        $metadata = array(
            TokenInfo::TOKEN_SDK => [TokenInfo::TOKEN_SDK_VALUE],
            TokenInfo::TOKEN_SDK_VERSION => [$composerJson['version']],
            TokenInfo::TOKEN_DEV_KEY => [$this->devKey]
        );

        $channel = RpcChannelFactory::createChannel($this->hostName, $this->port, $this->useSsl, $this->timeoutMs, $metadata);

        return new TokenClient($channel, $this->tokenCluster, $this->cryptoEngine);
    }
}
