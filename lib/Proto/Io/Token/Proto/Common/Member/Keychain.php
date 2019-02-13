<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member.proto

namespace Io\Token\Proto\Common\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.member.Keychain</code>
 */
class Keychain extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string keychain_id = 1;</code>
     */
    private $keychain_id = '';
    /**
     * Generated from protobuf field <code>string name = 2;</code>
     */
    private $name = '';
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.security.Key keys = 3;</code>
     */
    private $keys;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $keychain_id
     *     @type string $name
     *     @type \Io\Token\Proto\Common\Security\Key[]|\Google\Protobuf\Internal\RepeatedField $keys
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Member::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string keychain_id = 1;</code>
     * @return string
     */
    public function getKeychainId()
    {
        return $this->keychain_id;
    }

    /**
     * Generated from protobuf field <code>string keychain_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setKeychainId($var)
    {
        GPBUtil::checkString($var, True);
        $this->keychain_id = $var;

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
     * Generated from protobuf field <code>repeated .io.token.proto.common.security.Key keys = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.security.Key keys = 3;</code>
     * @param \Io\Token\Proto\Common\Security\Key[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setKeys($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Security\Key::class);
        $this->keys = $arr;

        return $this;
    }

}

