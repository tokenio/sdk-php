<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Refers to a Token member by ID or by alias.
 *
 * Generated from protobuf message <code>io.token.proto.common.token.TokenMember</code>
 */
class TokenMember extends \Google\Protobuf\Internal\Message
{
    /**
     * member ID
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * TODO(PR-1161): Rename this when we no longer require backwards compatibility with usernames
     *
     * Generated from protobuf field <code>string username = 2;</code>
     */
    private $username = '';
    /**
     * alias, such as an email address
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias alias = 3;</code>
     */
    private $alias = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           member ID
     *     @type string $username
     *           TODO(PR-1161): Rename this when we no longer require backwards compatibility with usernames
     *     @type \Io\Token\Proto\Common\Alias\Alias $alias
     *           alias, such as an email address
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * member ID
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * member ID
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
     * TODO(PR-1161): Rename this when we no longer require backwards compatibility with usernames
     *
     * Generated from protobuf field <code>string username = 2;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * TODO(PR-1161): Rename this when we no longer require backwards compatibility with usernames
     *
     * Generated from protobuf field <code>string username = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

    /**
     * alias, such as an email address
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias alias = 3;</code>
     * @return \Io\Token\Proto\Common\Alias\Alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * alias, such as an email address
     *
     * Generated from protobuf field <code>.io.token.proto.common.alias.Alias alias = 3;</code>
     * @param \Io\Token\Proto\Common\Alias\Alias $var
     * @return $this
     */
    public function setAlias($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Alias\Alias::class);
        $this->alias = $var;

        return $this;
    }

}

