<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.StoreLinkingRequestResponse</code>
 */
class StoreLinkingRequestResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string linking_request_id = 1;</code>
     */
    private $linking_request_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $linking_request_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string linking_request_id = 1;</code>
     * @return string
     */
    public function getLinkingRequestId()
    {
        return $this->linking_request_id;
    }

    /**
     * Generated from protobuf field <code>string linking_request_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setLinkingRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->linking_request_id = $var;

        return $this;
    }

}

