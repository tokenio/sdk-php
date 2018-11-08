<?php

namespace Tokenio\Http\Request;

use Google\Protobuf\Internal\MapField;
use Io\Token\Proto\Common\Token\TokenPayload;

class TokenRequest
{
    /**
     * @var TokenPayload
     */
    private $tokenPayload;

    /**
     * @var MapField
     */
    private $options;

    /**
     * @var string
     */
    private $userRefId;

    /**
     * @var string
     */
    private $customizationId;

    /**
     * TokenRequest constructor.
     *
     * @param TokenPayload $tokenPayload
     * @param string[] $options
     * @param string $userRefId
     * @param string $customizationId
     */
    public function __construct($tokenPayload, $options, $userRefId, $customizationId)
    {
        $this->tokenPayload = $tokenPayload;
        $this->options = $options;
        $this->userRefId = $userRefId;
        $this->customizationId = $customizationId;
    }

    /**
     * @return TokenPayload
     */
    public function getTokenPayload()
    {
        return $this->tokenPayload;
    }

    /**
     * @return MapField
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getUserRefId()
    {
        return $this->userRefId;
    }

    /**
     * @return string
     */
    public function getCustomizationId()
    {
        return $this->customizationId;
    }

    /**
     * @param TokenPayload $tokenPayload
     * @return TokenRequestBuilder
     */
    public static function builder($tokenPayload)
    {
        return new TokenRequestBuilder($tokenPayload);
    }
}