<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: alias.proto

namespace Io\Token\Proto\Common\Alias;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An Alias refers to a member in a "human readable" way.
 * Normally, an alias must be verified before it's useful.
 * E.g., payments to { EMAIL, "sandy&#64;example.com" } work only if
 * some member has verified receiving an email at that address.
 *
 * Generated from protobuf message <code>io.token.proto.common.alias.Alias</code>
 */
class Alias extends \Google\Protobuf\Internal\Message
{
    /**
     * For example, EMAIL.
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias.Type type = 1;</code>
     */
    private $type = 0;
    /**
     * For example, "sandy&#64;example.com"
     *
     * Generated from protobuf field <code>string value = 2 [(.io.token.proto.extensions.field.redact) = true];</code>
     */
    private $value = '';
    /**
     * For example, "token"
     *
     * Generated from protobuf field <code>string realm = 3 [deprecated = true];</code>
     */
    private $realm = '';
    /**
     * member_id of existing Member
     *
     * Generated from protobuf field <code>string realm_id = 4;</code>
     */
    private $realm_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type
     *           For example, EMAIL.
     *     @type string $value
     *           For example, "sandy&#64;example.com"
     *     @type string $realm
     *           For example, "token"
     *     @type string $realm_id
     *           member_id of existing Member
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Alias::initOnce();
        parent::__construct($data);
    }

    /**
     * For example, EMAIL.
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias.Type type = 1;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * For example, EMAIL.
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias.Type type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Alias\Alias_Type::class);
        $this->type = $var;

        return $this;
    }

    /**
     * For example, "sandy&#64;example.com"
     *
     * Generated from protobuf field <code>string value = 2 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * For example, "sandy&#64;example.com"
     *
     * Generated from protobuf field <code>string value = 2 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;

        return $this;
    }

    /**
     * For example, "token"
     *
     * Generated from protobuf field <code>string realm = 3 [deprecated = true];</code>
     * @return string
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * For example, "token"
     *
     * Generated from protobuf field <code>string realm = 3 [deprecated = true];</code>
     * @param string $var
     * @return $this
     */
    public function setRealm($var)
    {
        GPBUtil::checkString($var, True);
        $this->realm = $var;

        return $this;
    }

    /**
     * member_id of existing Member
     *
     * Generated from protobuf field <code>string realm_id = 4;</code>
     * @return string
     */
    public function getRealmId()
    {
        return $this->realm_id;
    }

    /**
     * member_id of existing Member
     *
     * Generated from protobuf field <code>string realm_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setRealmId($var)
    {
        GPBUtil::checkString($var, True);
        $this->realm_id = $var;

        return $this;
    }

}

