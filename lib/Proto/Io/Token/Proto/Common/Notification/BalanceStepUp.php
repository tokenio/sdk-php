<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: notification.proto

namespace Io\Token\Proto\Common\Notification;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A notification to step up a get balance(s) request
 *
 * Generated from protobuf message <code>io.token.proto.common.notification.BalanceStepUp</code>
 */
class BalanceStepUp extends \Google\Protobuf\Internal\Message
{
    /**
     * Account IDs
     *
     * Generated from protobuf field <code>repeated string account_id = 1;</code>
     */
    private $account_id;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $account_id
     *           Account IDs
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Notification::initOnce();
        parent::__construct($data);
    }

    /**
     * Account IDs
     *
     * Generated from protobuf field <code>repeated string account_id = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Account IDs
     *
     * Generated from protobuf field <code>repeated string account_id = 1;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAccountId($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->account_id = $arr;

        return $this;
    }

}

