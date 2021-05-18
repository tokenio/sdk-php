<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

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
	                                    $continuation,
                                        array $metadata = [],
                                        array $options = [])
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

        return parent::interceptUnaryUnary($method, $argument, $deserialize, $continuation, $metadata, $options);
    }
}
