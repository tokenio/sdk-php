<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member.proto

namespace Io\Token\Proto\Common\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A member address record
 *
 * Generated from protobuf message <code>io.token.proto.common.member.AddressRecord</code>
 */
class AddressRecord extends \Google\Protobuf\Internal\Message
{
    /**
     * Address id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * The display name of the address, e.g., "Office"
     *
     * Generated from protobuf field <code>string name = 2;</code>
     */
    private $name = '';
    /**
     * Country specific JSON address
     *
     * Generated from protobuf field <code>.io.token.proto.common.address.Address address = 3;</code>
     */
    private $address = null;
    /**
     * member signature of the address
     *
     * Generated from protobuf field <code>.io.token.proto.common.security.Signature address_signature = 4;</code>
     */
    private $address_signature = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           Address id
     *     @type string $name
     *           The display name of the address, e.g., "Office"
     *     @type \Io\Token\Proto\Common\Address\Address $address
     *           Country specific JSON address
     *     @type \Io\Token\Proto\Common\Security\Signature $address_signature
     *           member signature of the address
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Member::initOnce();
        parent::__construct($data);
    }

    /**
     * Address id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Address id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * The display name of the address, e.g., "Office"
     *
     * Generated from protobuf field <code>string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The display name of the address, e.g., "Office"
     *
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
     * Country specific JSON address
     *
     * Generated from protobuf field <code>.io.token.proto.common.address.Address address = 3;</code>
     * @return \Io\Token\Proto\Common\Address\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Country specific JSON address
     *
     * Generated from protobuf field <code>.io.token.proto.common.address.Address address = 3;</code>
     * @param \Io\Token\Proto\Common\Address\Address $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Address\Address::class);
        $this->address = $var;

        return $this;
    }

    /**
     * member signature of the address
     *
     * Generated from protobuf field <code>.io.token.proto.common.security.Signature address_signature = 4;</code>
     * @return \Io\Token\Proto\Common\Security\Signature
     */
    public function getAddressSignature()
    {
        return $this->address_signature;
    }

    /**
     * member signature of the address
     *
     * Generated from protobuf field <code>.io.token.proto.common.security.Signature address_signature = 4;</code>
     * @param \Io\Token\Proto\Common\Security\Signature $var
     * @return $this
     */
    public function setAddressSignature($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Security\Signature::class);
        $this->address_signature = $var;

        return $this;
    }

}

