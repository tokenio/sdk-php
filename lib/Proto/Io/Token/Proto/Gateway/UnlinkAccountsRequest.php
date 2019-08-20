<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.UnlinkAccountsRequest</code>
 */
class UnlinkAccountsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * IDs of accounts to unlink
     *
     * Generated from protobuf field <code>repeated string account_ids = 1;</code>
     */
    private $account_ids;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $account_ids
     *           IDs of accounts to unlink
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * IDs of accounts to unlink
     *
     * Generated from protobuf field <code>repeated string account_ids = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAccountIds()
    {
        return $this->account_ids;
    }

    /**
     * IDs of accounts to unlink
     *
     * Generated from protobuf field <code>repeated string account_ids = 1;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAccountIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->account_ids = $arr;

        return $this;
    }

}

