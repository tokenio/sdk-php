<?php

namespace Tokenio\Rpc;

use Grpc\Channel;
use Io\Token\Proto\Gateway\GatewayServiceClient;
use Tokenio\Security\CryptoEngineInterface;

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
        return new Client($memberId, $cryptoEngine, $channel);
    }
}