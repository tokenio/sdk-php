<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.CreateTransferTokenRequest</code>
 */
class CreateTransferTokenRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * TokenPayload, should have TransferBody
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     */
    private $payload = null;
    /**
     * ID of the token request
     *
     * Generated from protobuf field <code>string token_request_id = 2;</code>
     */
    private $token_request_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Token\TokenPayload $payload
     *           TokenPayload, should have TransferBody
     *     @type string $token_request_id
     *           ID of the token request
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * TokenPayload, should have TransferBody
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     * @return \Io\Token\Proto\Common\Token\TokenPayload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * TokenPayload, should have TransferBody
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     * @param \Io\Token\Proto\Common\Token\TokenPayload $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\TokenPayload::class);
        $this->payload = $var;

        return $this;
    }

    /**
     * ID of the token request
     *
     * Generated from protobuf field <code>string token_request_id = 2;</code>
     * @return string
     */
    public function getTokenRequestId()
    {
        return $this->token_request_id;
    }

    /**
     * ID of the token request
     *
     * Generated from protobuf field <code>string token_request_id = 2;</code>
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

