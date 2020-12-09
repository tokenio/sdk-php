<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: providerspecific.proto

namespace Io\Token\Proto\Common\Providerspecific;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Used in embedded auth flows
 *
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.CredentialField</code>
 */
class CredentialField extends \Google\Protobuf\Internal\Message
{
    /**
     * ID to be used when passing the value of this credential
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * display name of the credential
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     */
    private $display_name = '';
    /**
     * optional; used when there is a selection of options, e.g. SMS message, phone call
     *
     * Generated from protobuf field <code>repeated string options = 3;</code>
     */
    private $options;
    /**
     * whether the credential is a password
     *
     * Generated from protobuf field <code>bool password = 4;</code>
     */
    private $password = false;
    /**
     * Generated from protobuf field <code>string description = 5;</code>
     */
    private $description = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           ID to be used when passing the value of this credential
     *     @type string $display_name
     *           display name of the credential
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $options
     *           optional; used when there is a selection of options, e.g. SMS message, phone call
     *     @type bool $password
     *           whether the credential is a password
     *     @type string $description
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Providerspecific::initOnce();
        parent::__construct($data);
    }

    /**
     * ID to be used when passing the value of this credential
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ID to be used when passing the value of this credential
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
     * display name of the credential
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * display name of the credential
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

    /**
     * optional; used when there is a selection of options, e.g. SMS message, phone call
     *
     * Generated from protobuf field <code>repeated string options = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * optional; used when there is a selection of options, e.g. SMS message, phone call
     *
     * Generated from protobuf field <code>repeated string options = 3;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOptions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->options = $arr;

        return $this;
    }

    /**
     * whether the credential is a password
     *
     * Generated from protobuf field <code>bool password = 4;</code>
     * @return bool
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * whether the credential is a password
     *
     * Generated from protobuf field <code>bool password = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkBool($var);
        $this->password = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string description = 5;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Generated from protobuf field <code>string description = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

}

