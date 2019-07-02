<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.BankAccountInfo</code>
 */
class BankAccountInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string bic_or_swift = 1;</code>
     */
    private $bic_or_swift = '';
    /**
     * Generated from protobuf field <code>string name = 2;</code>
     */
    private $name = '';
    /**
     * Generated from protobuf field <code>repeated string address = 3;</code>
     */
    private $address;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bic_or_swift
     *     @type string $name
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $address
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string bic_or_swift = 1;</code>
     * @return string
     */
    public function getBicOrSwift()
    {
        return $this->bic_or_swift;
    }

    /**
     * Generated from protobuf field <code>string bic_or_swift = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBicOrSwift($var)
    {
        GPBUtil::checkString($var, True);
        $this->bic_or_swift = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>string name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string address = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Generated from protobuf field <code>repeated string address = 3;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAddress($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->address = $arr;

        return $this;
    }

}

