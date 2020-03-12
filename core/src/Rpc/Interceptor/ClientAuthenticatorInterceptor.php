<?php

namespace Tokenio\Rpc\Interceptor;

use Google\Protobuf\Internal\Message;
use Grpc\Interceptor;
use Io\Token\Proto\Gateway\GrpcAuthPayload;
use Tokenio\Rpc\AuthenticationContext;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Util\Strings;

class ClientAuthenticatorInterceptor extends Interceptor
{
    /**
     * @var string
     */
    private $memberId;

    /**
     * @var CryptoEngineInterface
     */
    private $cryptoEngine;

    private $authenticationContext;

    /**
     * Construct the ClientAuthenticatorInterceptor.
     *
     * @param string $memberId
     * @param CryptoEngineInterface $cryptoEngine
     * @param AuthenticationContext $authenticationContext
     */
    public function __construct($memberId, $cryptoEngine, $authenticationContext)
    {
        $this->memberId = $memberId;
        $this->cryptoEngine = $cryptoEngine;
        $this->authenticationContext = $authenticationContext;
    }

    public function interceptUnaryUnary($method,
                                        $argument,
                                        $deserialize,
                                        array $metadata = [],
                                        array $options = [],
                                        $continuation)
    {
        /** @var Message $argument */
        $now = round(microtime(true) * 1000);
        $payload = new GrpcAuthPayload();
        $payload->setRequest($argument->serializeToString())->setCreatedAtMs($now);

        $keyLevel = $this->authenticationContext->getKeyLevel();
        $signer = $this->cryptoEngine->createSigner($keyLevel);
        $signature = $signer->sign($payload);

        $metadata['token-realm'] = ['Token'];
        $metadata['token-scheme'] = ['Token-Ed25519-SHA512'];
        $metadata['token-key-id'] = [$signer->getKeyId()];
        $metadata['token-signature'] = [$signature];
        $metadata['token-created-at-ms'] = [(string)$now];
        $metadata['token-member-id'] = [$this->memberId];

        $customer = $this->authenticationContext->getCustomerTrackingMetadata();
        if (!empty($customer->getIpAddress())) {
            $metadata["token-customer-ip-address"] =  $customer->getIpAddress();
        }
        if (!empty($customer->getGeoLocation())) {
            $metadata["token-customer-geo-location"] = $customer->getGeoLocation();
        }
        if (!empty($customer->getDeviceId())) {
            $metadata["token-customer-device-id"] = $customer->getDeviceId();
        }

        $onBehalfOf = $this->authenticationContext->getOnBehalfOf();
        if (!Strings::isEmptyString($onBehalfOf)) {
            $metadata['token-on-behalf-of'] = [$onBehalfOf];
            $metadata['customer-initiated'] = [$this->authenticationContext->getCustomerInitiated() ? 'true' : 'false'];
        }

        return parent::interceptUnaryUnary($method, $argument, $deserialize, $metadata, $options, $continuation);
    }
}
