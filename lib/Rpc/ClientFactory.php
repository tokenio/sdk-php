<?php

namespace Io\Token\Rpc;

use Grpc\Channel;
use Grpc\Interceptor;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Io\Token\Rpc\Interceptor\ClientAuthenticatorInterceptor;
use Io\Token\Security\CryptoEngineInterface;

abstract class ClientFactory
{
    /**
     * Create a unauthenticated client
     *
     * @param Channel $channel
     * @return UnauthenticatedClient
     */
    public static function unauthenticated($channel)
    {
        $gateway = new GatewayServiceClient($channel->getTarget(), [], $channel);
        return new UnauthenticatedClient($gateway);
    }

    /**
     * Creates authenticated client backed by the specified channel.
     * The supplied signer is used to authenticate the caller for every call.
     *
     * @param Channel $channel the RPC channel to use
     * @param string $memberId the member id
     * @param CryptoEngineInterface $cryptoEngine the engine to use for signing requests, tokens, etc
     * @return Client
     */
    public static function authenticated($channel, $memberId, $cryptoEngine)
    {
        $interceptors = array(new ClientAuthenticatorInterceptor($memberId, $cryptoEngine));

        /** @var \Grpc\Internal\InterceptorChannel $channel */
        $channel = Interceptor::intercept($channel, $interceptors);

        $gateway = new GatewayServiceClient($channel->getTarget(), [], $channel);
        return new Client($memberId, $cryptoEngine, $gateway);
    }
}
