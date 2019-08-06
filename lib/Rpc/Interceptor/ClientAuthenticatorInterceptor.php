<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace Io\Token\Rpc\Interceptor;

use Google\Protobuf\Internal\Message;
use Grpc\Interceptor;
use Io\Token\Proto\Gateway\GrpcAuthPayload;
use Io\Token\Rpc\AuthenticationContext;
use Io\Token\Security\CryptoEngineInterface;
use Io\Token\Util\Strings;

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

    /**
     * Construct the ClientAuthenticatorInterceptor.
     *
     * @param string $memberId
     * @param CryptoEngineInterface $cryptoEngine
     */
    public function __construct($memberId, $cryptoEngine)
    {
        $this->memberId = $memberId;
        $this->cryptoEngine = $cryptoEngine;
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

        $keyLevel = AuthenticationContext::resetKeyLevel();
        $signer = $this->cryptoEngine->createSigner($keyLevel);
        $signature = $signer->sign($payload);

        $metadata['token-realm'] = ['Token'];
        $metadata['token-scheme'] = ['Token-Ed25519-SHA512'];
        $metadata['token-key-id'] = [$signer->getKeyId()];
        $metadata['token-signature'] = [$signature];
        $metadata['token-created-at-ms'] = [(string)$now];
        $metadata['token-member-id'] = [$this->memberId];

        $onBehalfOf = AuthenticationContext::getOnBehalfOf();
        if (!Strings::isEmptyString($onBehalfOf)) {
            $metadata['token-on-behalf-of'] = [$onBehalfOf];
            $metadata['customer-initiated'] = [AuthenticationContext::getCustomerInitiated() ? 'true' : 'false'];
            AuthenticationContext::clearAccessToken();
        }

        return parent::interceptUnaryUnary($method, $argument, $deserialize, $metadata, $options, $continuation);
    }
}
