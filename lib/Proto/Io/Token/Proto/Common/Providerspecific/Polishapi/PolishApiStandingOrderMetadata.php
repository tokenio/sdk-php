<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.PolishApiStandingOrderMetadata</code>
 */
class PolishApiStandingOrderMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.DeliveryMode delivery_mode = 1;</code>
     */
    private $delivery_mode = 0;
    /**
     * indicates that the funds should be reserved until the payment is executable (e.g. for Bank holidays)
     *
     * Generated from protobuf field <code>bool hold = 2;</code>
     */
    private $hold = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $delivery_mode
     *     @type bool $hold
     *           indicates that the funds should be reserved until the payment is executable (e.g. for Bank holidays)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Provider\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.DeliveryMode delivery_mode = 1;</code>
     * @return int
     */
    public function getDeliveryMode()
    {
        return $this->delivery_mode;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.DeliveryMode delivery_mode = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setDeliveryMode($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\DeliveryMode::class);
        $this->delivery_mode = $var;

        return $this;
    }

    /**
     * indicates that the funds should be reserved until the payment is executable (e.g. for Bank holidays)
     *
     * Generated from protobuf field <code>bool hold = 2;</code>
     * @return bool
     */
    public function getHold()
    {
        return $this->hold;
    }

    /**
     * indicates that the funds should be reserved until the payment is executable (e.g. for Bank holidays)
     *
     * Generated from protobuf field <code>bool hold = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setHold($var)
    {
        GPBUtil::checkBool($var);
        $this->hold = $var;

        return $this;
    }

}

