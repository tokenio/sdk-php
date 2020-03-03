<?php

namespace Tokenio\Tpp\TokenRequest;

use Io\Token\Proto\Common\Security\Signature;
use Tokenio\Tpp\Exception\InvalidTokenRequestQuery;

class TokenRequestCallbackParameters
{
    const TOKEN_ID_FIELD = 'tokenId';
    const STATE_FIELD = 'state';
    const SIGNATURE_FIELD = 'signature';

    /**
     * @var string
     */
    private $tokenId;

    /**
     * @var string
     */
    private $state;

    /**
     * @var Signature
     */
    private $signature;

    /**
     * @param array $parameters
     * @return TokenRequestCallbackParameters
     * @throws \Exception
     */
    public static function create($parameters)
    {
        if (!isset($parameters[self::TOKEN_ID_FIELD], $parameters[self::STATE_FIELD], $parameters[self::SIGNATURE_FIELD])) {
            throw new InvalidTokenRequestQuery();
        }

        $signatureJson = json_decode($parameters[self::SIGNATURE_FIELD]);
        $signature = new Signature();
        $signature->setMemberId($signatureJson->memberId)
            ->setKeyId($signatureJson->keyId)
            ->setSignature($signatureJson->signature);

        return new TokenRequestCallbackParameters($parameters[self::TOKEN_ID_FIELD], $parameters[self::STATE_FIELD], $signature);
    }

    private function __construct($tokenId, $state, $signature)
    {
        $this->tokenId = $tokenId;
        $this->state = $state;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getSerializedState()
    {
        return $this->state;
    }

    /**
     * @return Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
