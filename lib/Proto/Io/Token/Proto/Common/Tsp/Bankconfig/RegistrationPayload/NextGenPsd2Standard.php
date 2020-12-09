<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: tsp/bankconfig.proto

namespace Io\Token\Proto\Common\Tsp\Bankconfig\RegistrationPayload;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.tsp.bankconfig.RegistrationPayload.NextGenPsd2Standard</code>
 */
class NextGenPsd2Standard extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string transport_key_id = 1;</code>
     */
    private $transport_key_id = '';
    /**
     * Generated from protobuf field <code>string signing_key_id = 2;</code>
     */
    private $signing_key_id = '';
    /**
     * Generated from protobuf field <code>repeated string callback_urls = 3;</code>
     */
    private $callback_urls;
    /**
     * Generated from protobuf field <code>string contact_email = 4;</code>
     */
    private $contact_email = '';
    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     */
    private $app_name = '';
    /**
     * Generated from protobuf field <code>string app_description = 6;</code>
     */
    private $app_description = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $transport_key_id
     *     @type string $signing_key_id
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $callback_urls
     *     @type string $contact_email
     *     @type string $app_name
     *     @type string $app_description
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Tsp\Bankconfig::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string transport_key_id = 1;</code>
     * @return string
     */
    public function getTransportKeyId()
    {
        return $this->transport_key_id;
    }

    /**
     * Generated from protobuf field <code>string transport_key_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTransportKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->transport_key_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string signing_key_id = 2;</code>
     * @return string
     */
    public function getSigningKeyId()
    {
        return $this->signing_key_id;
    }

    /**
     * Generated from protobuf field <code>string signing_key_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSigningKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->signing_key_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string callback_urls = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getCallbackUrls()
    {
        return $this->callback_urls;
    }

    /**
     * Generated from protobuf field <code>repeated string callback_urls = 3;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setCallbackUrls($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->callback_urls = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string contact_email = 4;</code>
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * Generated from protobuf field <code>string contact_email = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setContactEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->contact_email = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     * @return string
     */
    public function getAppName()
    {
        return $this->app_name;
    }

    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setAppName($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string app_description = 6;</code>
     * @return string
     */
    public function getAppDescription()
    {
        return $this->app_description;
    }

    /**
     * Generated from protobuf field <code>string app_description = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setAppDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_description = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(NextGenPsd2Standard::class, \Io\Token\Proto\Common\Tsp\Bankconfig\RegistrationPayload_NextGenPsd2Standard::class);
