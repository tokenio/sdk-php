<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/stet.proto

namespace Io\Token\Proto\Common\Providerspecific\Stet;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.stet.PartyIdentification</code>
 */
class PartyIdentification extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.PostalAddress postal_address = 2;</code>
     */
    private $postal_address = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification organisation_id = 3;</code>
     */
    private $organisation_id = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification private_id = 4;</code>
     */
    private $private_id = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *     @type \Io\Token\Proto\Common\Providerspecific\Stet\PostalAddress $postal_address
     *     @type \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification $organisation_id
     *     @type \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification $private_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Provider\Stet::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>string name = 1;</code>
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
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.PostalAddress postal_address = 2;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Stet\PostalAddress
     */
    public function getPostalAddress()
    {
        return $this->postal_address;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.PostalAddress postal_address = 2;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Stet\PostalAddress $var
     * @return $this
     */
    public function setPostalAddress($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Stet\PostalAddress::class);
        $this->postal_address = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification organisation_id = 3;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification
     */
    public function getOrganisationId()
    {
        return $this->organisation_id;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification organisation_id = 3;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification $var
     * @return $this
     */
    public function setOrganisationId($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification::class);
        $this->organisation_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification private_id = 4;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification
     */
    public function getPrivateId()
    {
        return $this->private_id;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.stet.GenericIdentification private_id = 4;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification $var
     * @return $this
     */
    public function setPrivateId($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Stet\GenericIdentification::class);
        $this->private_id = $var;

        return $this;
    }

}
