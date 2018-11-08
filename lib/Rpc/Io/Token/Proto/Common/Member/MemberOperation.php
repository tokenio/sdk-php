<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member.proto

namespace Io\Token\Proto\Common\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.member.MemberOperation</code>
 */
class MemberOperation extends \Google\Protobuf\Internal\Message
{
    protected $operation;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Member\MemberAddKeyOperation $add_key
     *     @type \Io\Token\Proto\Common\Member\MemberRemoveKeyOperation $remove_key
     *     @type \Io\Token\Proto\Common\Member\MemberAliasOperation $remove_alias
     *     @type \Io\Token\Proto\Common\Member\MemberAliasOperation $add_alias
     *     @type \Io\Token\Proto\Common\Member\MemberAliasOperation $verify_alias
     *     @type \Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation $recovery_rules
     *     @type \Io\Token\Proto\Common\Member\MemberRecoveryOperation $recover
     *     @type \Io\Token\Proto\Common\Member\MemberDeleteOperation $delete
     *     @type \Io\Token\Proto\Common\Member\MemberPartnerOperation $verify_partner
     *     @type \Io\Token\Proto\Common\Member\MemberPartnerOperation $unverify_partner
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Member::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAddKeyOperation add_key = 1;</code>
     * @return \Io\Token\Proto\Common\Member\MemberAddKeyOperation
     */
    public function getAddKey()
    {
        return $this->readOneof(1);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAddKeyOperation add_key = 1;</code>
     * @param \Io\Token\Proto\Common\Member\MemberAddKeyOperation $var
     * @return $this
     */
    public function setAddKey($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberAddKeyOperation::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRemoveKeyOperation remove_key = 2;</code>
     * @return \Io\Token\Proto\Common\Member\MemberRemoveKeyOperation
     */
    public function getRemoveKey()
    {
        return $this->readOneof(2);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRemoveKeyOperation remove_key = 2;</code>
     * @param \Io\Token\Proto\Common\Member\MemberRemoveKeyOperation $var
     * @return $this
     */
    public function setRemoveKey($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberRemoveKeyOperation::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation remove_alias = 4;</code>
     * @return \Io\Token\Proto\Common\Member\MemberAliasOperation
     */
    public function getRemoveAlias()
    {
        return $this->readOneof(4);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation remove_alias = 4;</code>
     * @param \Io\Token\Proto\Common\Member\MemberAliasOperation $var
     * @return $this
     */
    public function setRemoveAlias($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberAliasOperation::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation add_alias = 5;</code>
     * @return \Io\Token\Proto\Common\Member\MemberAliasOperation
     */
    public function getAddAlias()
    {
        return $this->readOneof(5);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation add_alias = 5;</code>
     * @param \Io\Token\Proto\Common\Member\MemberAliasOperation $var
     * @return $this
     */
    public function setAddAlias($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberAliasOperation::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation verify_alias = 6;</code>
     * @return \Io\Token\Proto\Common\Member\MemberAliasOperation
     */
    public function getVerifyAlias()
    {
        return $this->readOneof(6);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberAliasOperation verify_alias = 6;</code>
     * @param \Io\Token\Proto\Common\Member\MemberAliasOperation $var
     * @return $this
     */
    public function setVerifyAlias($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberAliasOperation::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRecoveryRulesOperation recovery_rules = 7;</code>
     * @return \Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation
     */
    public function getRecoveryRules()
    {
        return $this->readOneof(7);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRecoveryRulesOperation recovery_rules = 7;</code>
     * @param \Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation $var
     * @return $this
     */
    public function setRecoveryRules($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRecoveryOperation recover = 8;</code>
     * @return \Io\Token\Proto\Common\Member\MemberRecoveryOperation
     */
    public function getRecover()
    {
        return $this->readOneof(8);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberRecoveryOperation recover = 8;</code>
     * @param \Io\Token\Proto\Common\Member\MemberRecoveryOperation $var
     * @return $this
     */
    public function setRecover($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberRecoveryOperation::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberDeleteOperation delete = 9;</code>
     * @return \Io\Token\Proto\Common\Member\MemberDeleteOperation
     */
    public function getDelete()
    {
        return $this->readOneof(9);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberDeleteOperation delete = 9;</code>
     * @param \Io\Token\Proto\Common\Member\MemberDeleteOperation $var
     * @return $this
     */
    public function setDelete($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberDeleteOperation::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberPartnerOperation verify_partner = 10;</code>
     * @return \Io\Token\Proto\Common\Member\MemberPartnerOperation
     */
    public function getVerifyPartner()
    {
        return $this->readOneof(10);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberPartnerOperation verify_partner = 10;</code>
     * @param \Io\Token\Proto\Common\Member\MemberPartnerOperation $var
     * @return $this
     */
    public function setVerifyPartner($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberPartnerOperation::class);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberPartnerOperation unverify_partner = 11;</code>
     * @return \Io\Token\Proto\Common\Member\MemberPartnerOperation
     */
    public function getUnverifyPartner()
    {
        return $this->readOneof(11);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.member.MemberPartnerOperation unverify_partner = 11;</code>
     * @param \Io\Token\Proto\Common\Member\MemberPartnerOperation $var
     * @return $this
     */
    public function setUnverifyPartner($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\MemberPartnerOperation::class);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->whichOneof("operation");
    }

}

