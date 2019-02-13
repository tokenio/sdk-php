<?php

namespace Tokenio\Rpc;

use Grpc\Channel;
use Grpc\ChannelCredentials;
use Grpc\Interceptor;
use Tokenio\Rpc\Interceptor\MetadataInterceptor;
use Tokenio\Rpc\Interceptor\TimeoutInterceptor;

abstract class RpcChannelFactory
{
    /**
     * Creates a channel that connects to a specific host and port.
     *
     * @param string $host the name or IP address of the host.
     * @param int $port the port
     * @param bool $useSsl
     * @param $timeoutMs
     * @param array $metadata
     * @return mixed
     */
    public static function createChannel($host, $port, $useSsl, $timeoutMs, $metadata = [])
    {
        if ($useSsl) {
            $credentials = ChannelCredentials::createSsl(null);
        } else {
            $credentials = ChannelCredentials::createInsecure();
        }

        $channel = new Channel(
            sprintf('%s:%d', $host, $port),
            array('credentials' => $credentials)
        );

        $interceptors = array(
            new TimeoutInterceptor($timeoutMs),
            new MetadataInterceptor($metadata)
        );

        return Interceptor::intercept($channel, $interceptors);
    }
}
