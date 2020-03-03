<?php

namespace Tokenio;

use InvalidArgumentException;

class TokenCluster
{
    private $url;
    private $webUrl;

    /**
     * Construct the TokenCluster.
     *
     * @param string $url the api url
     * @param string $webUrl the web api url
     */
    public function __construct($url, $webUrl)
    {
        $this->url = $url;
        $this->webUrl = $webUrl;
    }

    /**
     * Provides the TokenCluster by environment.
     *
     * @param int $environment the token environment
     * @return TokenCluster
     */
    public static function get($environment)
    {
        switch ($environment) {
            case TokenEnvironment::DEVELOPMENT:
                return self::getDevelopment();

            case TokenEnvironment::PERFORMANCE:
                return self::getPerformance();

            case TokenEnvironment::STAGING:
                return self::getStaging();

            case TokenEnvironment::SANDBOX:
                return self::getSandbox();

            case TokenEnvironment::INTEGRATION:
                return self::getIntegration();

            case TokenEnvironment::PRODUCTION:
                return self::getProduction();
        }

        throw new InvalidArgumentException("Invalid environment was provided.");
    }

    /**
     * @return TokenCluster
     */
    public static function getDevelopment()
    {
        return new TokenCluster('api-grpc.dev.token.io', 'web-app.dev.token.io');
    }

    /**
     * @return TokenCluster
     */
    public static function getPerformance()
    {
        return new TokenCluster('api-grpc.perf.token.io', 'web-app.perf.token.io');
    }

    /**
     * @return TokenCluster
     */
    public static function getStaging()
    {
        return new TokenCluster('api-grpc.stg.token.io', 'web-app.stg.token.io');
    }

    /**
     * @return TokenCluster
     */
    public static function getSandbox()
    {
        return new TokenCluster('api-grpc.sandbox.token.io', 'web-app.sandbox.token.io');
    }

    /**
     * @return TokenCluster
     */
    public static function getIntegration()
    {
        return new TokenCluster('api-grpc.int.token.io', 'web-app.int.token.io');
    }

    /**
     * @return TokenCluster
     */
    public static function getProduction()
    {
        return new TokenCluster('api-grpc.token.io', 'web-app.token.io');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }
}
