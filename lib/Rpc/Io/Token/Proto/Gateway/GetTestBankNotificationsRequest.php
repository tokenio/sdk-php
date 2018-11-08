<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetTestBankNotificationsRequest</code>
 */
class GetTestBankNotificationsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * subscriber ID
     *
     * Generated from protobuf field <code>string subscriber_id = 1;</code>
     */
    private $subscriber_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $subscriber_id
     *           subscriber ID
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * subscriber ID
     *
     * Generated from protobuf field <code>string subscriber_id = 1;</code>
     * @return string
     */
    public function getSubscriberId()
    {
        return $this->subscriber_id;
    }

    /**
     * subscriber ID
     *
     * Generated from protobuf field <code>string subscriber_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSubscriberId($var)
    {
        GPBUtil::checkString($var, True);
        $this->subscriber_id = $var;

        return $this;
    }

}

