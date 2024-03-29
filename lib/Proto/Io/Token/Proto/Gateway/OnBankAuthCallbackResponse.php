<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.OnBankAuthCallbackResponse</code>
 */
class OnBankAuthCallbackResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string token_request_id = 1;</code>
     */
    private $token_request_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $token_request_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string token_request_id = 1;</code>
     * @return string
     */
    public function getTokenRequestId()
    {
        return $this->token_request_id;
    }

    /**
     * Generated from protobuf field <code>string token_request_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_request_id = $var;

        return $this;
    }

}

