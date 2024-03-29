<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: security.proto

namespace Io\Token\Proto\Common\Security;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.security.CustomerTrackingMetadata</code>
 */
class CustomerTrackingMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * IP address of the customer. Required when the request is initiated by the customer, which means the request is exempted from the PSD2 data access restriction.
     *
     * Generated from protobuf field <code>string ip_address = 1;</code>
     */
    private $ip_address = '';
    /**
     * Optional. Geographical location of the customer.
     *
     * Generated from protobuf field <code>string geo_location = 2;</code>
     */
    private $geo_location = '';
    /**
     * Optional. Universally Unique Identifier for a device of the customer that identifies either a device or a device dependent application installation.
     *
     * Generated from protobuf field <code>string device_id = 3;</code>
     */
    private $device_id = '';
    /**
     * Generated from protobuf field <code>string user_agent = 4;</code>
     */
    private $user_agent = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $ip_address
     *           IP address of the customer. Required when the request is initiated by the customer, which means the request is exempted from the PSD2 data access restriction.
     *     @type string $geo_location
     *           Optional. Geographical location of the customer.
     *     @type string $device_id
     *           Optional. Universally Unique Identifier for a device of the customer that identifies either a device or a device dependent application installation.
     *     @type string $user_agent
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Security::initOnce();
        parent::__construct($data);
    }

    /**
     * IP address of the customer. Required when the request is initiated by the customer, which means the request is exempted from the PSD2 data access restriction.
     *
     * Generated from protobuf field <code>string ip_address = 1;</code>
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * IP address of the customer. Required when the request is initiated by the customer, which means the request is exempted from the PSD2 data access restriction.
     *
     * Generated from protobuf field <code>string ip_address = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setIpAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->ip_address = $var;

        return $this;
    }

    /**
     * Optional. Geographical location of the customer.
     *
     * Generated from protobuf field <code>string geo_location = 2;</code>
     * @return string
     */
    public function getGeoLocation()
    {
        return $this->geo_location;
    }

    /**
     * Optional. Geographical location of the customer.
     *
     * Generated from protobuf field <code>string geo_location = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setGeoLocation($var)
    {
        GPBUtil::checkString($var, True);
        $this->geo_location = $var;

        return $this;
    }

    /**
     * Optional. Universally Unique Identifier for a device of the customer that identifies either a device or a device dependent application installation.
     *
     * Generated from protobuf field <code>string device_id = 3;</code>
     * @return string
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * Optional. Universally Unique Identifier for a device of the customer that identifies either a device or a device dependent application installation.
     *
     * Generated from protobuf field <code>string device_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setDeviceId($var)
    {
        GPBUtil::checkString($var, True);
        $this->device_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string user_agent = 4;</code>
     * @return string
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * Generated from protobuf field <code>string user_agent = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setUserAgent($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_agent = $var;

        return $this;
    }

}

