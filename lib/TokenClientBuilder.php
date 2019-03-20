<?php

namespace Tokenio;

use Tokenio\Rpc\RpcChannelFactory;
use Tokenio\RuntimeException;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\KeyStoreInterface;
use Tokenio\Security\TokenCryptoEngineFactory;
use Tokenio\TokenClient;
use Tokenio\TokenIO;
use Tokenio\Util\Strings;

class TokenClientBuilder
{
    const DEFAULT_DEV_KEY = "f3982819-5d8d-4123-9601-886df2780f42";
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
     * @return TokenIoBuilder
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
        $metadata = array(
            TokenInfo::TOKEN_SDK => [TokenInfo::TOKEN_SDK_VALUE],
            TokenInfo::TOKEN_SDK_VERSION => [TokenInfo::TOKEN_SDK_VERSION_VALUE],
            TokenInfo::TOKEN_DEV_KEY => [$this->devKey]
        );

        $channel = RpcChannelFactory::createChannel($this->hostName, $this->port, $this->useSsl, $this->timeoutMs, $metadata);

        return new TokenClient($channel, $this->tokenCluster, $this->cryptoEngine);
    }
}
