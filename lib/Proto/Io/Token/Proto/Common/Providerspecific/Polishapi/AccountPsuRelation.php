<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.AccountPsuRelation</code>
 */
class AccountPsuRelation extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfRelation type_of_relation = 1;</code>
     */
    private $type_of_relation = 0;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfProxy type_of_proxy = 2;</code>
     */
    private $type_of_proxy = 0;
    /**
     * Generated from protobuf field <code>int32 stake = 3;</code>
     */
    private $stake = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type_of_relation
     *     @type int $type_of_proxy
     *     @type int $stake
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfRelation type_of_relation = 1;</code>
     * @return int
     */
    public function getTypeOfRelation()
    {
        return $this->type_of_relation;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfRelation type_of_relation = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setTypeOfRelation($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\TypeOfRelation::class);
        $this->type_of_relation = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfProxy type_of_proxy = 2;</code>
     * @return int
     */
    public function getTypeOfProxy()
    {
        return $this->type_of_proxy;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TypeOfProxy type_of_proxy = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setTypeOfProxy($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\TypeOfProxy::class);
        $this->type_of_proxy = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 stake = 3;</code>
     * @return int
     */
    public function getStake()
    {
        return $this->stake;
    }

    /**
     * Generated from protobuf field <code>int32 stake = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setStake($var)
    {
        GPBUtil::checkInt32($var);
        $this->stake = $var;

        return $this;
    }

}

