<?php

namespace Tokenio;

use Composer\Factory;
use Tokenio\Exception\StatusRuntimeException;
use Tokenio\Rpc\RpcChannelFactory;
use Tokenio\Security\CryptoEngineFactoryInterface;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Security\KeyStoreInterface;
use Tokenio\Security\TokenCryptoEngineFactory;

class TokenClientBuilder
{
    const DEFAULT_DEV_KEY = "4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI";
    const DEFAULT_TIMEOUT_MS = 10000;
    const DEFAULT_SSL_PORT = 443;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var bool
     */
    protected $useSsl;

    /**
     * @var TokenCluster
     */
    protected $tokenCluster;

    /**
     * @var string
     */
    protected $hostName;

    /**
     * @var int
     */
    protected $timeoutMs;

    /**
     * @var CryptoEngineFactoryInterface
     */
    protected $cryptoEngine;

    /**
     * @var string
     */
    protected $devKey;

    /**
     * @var array
     */
    protected $featureCodes;

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
     * Sets the feature codes to be used with the client.
     *
     * @param array $featureCodes
     * @return TokenClientBuilder
     */
    public function withFeatureCodes($featureCodes)
    {
        $this->featureCodes = $featureCodes;
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

        return new TokenClient($channel, $this->cryptoEngine,  $this->tokenCluster);
    }

    protected function getHeaders()
    {
        $composerJson = json_decode(file_get_contents(Factory::getComposerFile()), true);
        $metadata = array(
            TokenInfo::TOKEN_SDK => [TokenInfo::TOKEN_SDK_VALUE],
            TokenInfo::TOKEN_SDK_VERSION => [$composerJson['version']],
            TokenInfo::TOKEN_DEV_KEY => [$this->devKey]
        );

        if ($this->featureCodes != null) {
            $metadata[TokenInfo::FEATURE_CODES] = $this->featureCodes;
        }
        return $metadata;
    }

    protected function getPlatform()
    {
        throw new StatusRuntimeException("UNIMPLEMENTED","");
    }
}
