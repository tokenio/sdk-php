<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\AccessBody\Resource;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * **DEPRECATED** Provides access to member balance on all accounts at a specific bank.
 * Normally used with AllAccountsAtBank (to get list of accounts)
 *
 * Generated from protobuf message <code>io.token.proto.common.token.AccessBody.Resource.AllBalancesAtBank</code>
 */
class AllBalancesAtBank extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string bank_id = 1;</code>
     */
    private $bank_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bank_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string bank_id = 1;</code>
     * @return string
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * Generated from protobuf field <code>string bank_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBankId($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_id = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AllBalancesAtBank::class, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllBalancesAtBank::class);

