<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetLinkingRequestResponse</code>
 */
class GetLinkingRequestResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string member_id = 1;</code>
     */
    private $member_id = '';
    /**
     * Generated from protobuf field <code>string callback_url = 2;</code>
     */
    private $callback_url = '';
    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenRequest token_request = 3;</code>
     */
    private $token_request = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $member_id
     *     @type string $callback_url
     *     @type \Io\Token\Proto\Common\Token\TokenRequest $token_request
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string member_id = 1;</code>
     * @return string
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Generated from protobuf field <code>string member_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMemberId($var)
    {
        GPBUtil::checkString($var, True);
        $this->member_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string callback_url = 2;</code>
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callback_url;
    }

    /**
     * Generated from protobuf field <code>string callback_url = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCallbackUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->callback_url = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenRequest token_request = 3;</code>
     * @return \Io\Token\Proto\Common\Token\TokenRequest
     */
    public function getTokenRequest()
    {
        return $this->token_request;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenRequest token_request = 3;</code>
     * @param \Io\Token\Proto\Common\Token\TokenRequest $var
     * @return $this
     */
    public function setTokenRequest($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\TokenRequest::class);
        $this->token_request = $var;

        return $this;
    }

}

