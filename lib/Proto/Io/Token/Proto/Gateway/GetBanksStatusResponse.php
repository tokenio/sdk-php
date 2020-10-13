<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetBanksStatusResponse</code>
 */
class GetBanksStatusResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBanksStatusResponse.BankStatus banks_status = 1;</code>
     */
    private $banks_status;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Gateway\GetBanksStatusResponse\BankStatus[]|\Google\Protobuf\Internal\RepeatedField $banks_status
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBanksStatusResponse.BankStatus banks_status = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getBanksStatus()
    {
        return $this->banks_status;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBanksStatusResponse.BankStatus banks_status = 1;</code>
     * @param \Io\Token\Proto\Gateway\GetBanksStatusResponse\BankStatus[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setBanksStatus($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Gateway\GetBanksStatusResponse\BankStatus::class);
        $this->banks_status = $arr;

        return $this;
    }

}
