<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\Policy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * require signatures of all listed members
 *
 * Generated from protobuf message <code>io.token.proto.common.token.Policy.AllSignatures</code>
 */
class AllSignatures extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.token.Policy.Signer signers = 1;</code>
     */
    private $signers;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Token\Policy\Signer[]|\Google\Protobuf\Internal\RepeatedField $signers
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.token.Policy.Signer signers = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSigners()
    {
        return $this->signers;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.token.Policy.Signer signers = 1;</code>
     * @param \Io\Token\Proto\Common\Token\Policy\Signer[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSigners($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Token\Policy\Signer::class);
        $this->signers = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AllSignatures::class, \Io\Token\Proto\Common\Token\Policy_AllSignatures::class);
