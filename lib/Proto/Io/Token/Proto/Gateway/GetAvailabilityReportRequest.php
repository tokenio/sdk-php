<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetAvailabilityReportRequest</code>
 */
class GetAvailabilityReportRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string bank_id = 1;</code>
     */
    private $bank_id = '';
    /**
     * Generated from protobuf field <code>int32 days_back = 2;</code>
     */
    private $days_back = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bank_id
     *     @type int $days_back
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
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

    /**
     * Generated from protobuf field <code>int32 days_back = 2;</code>
     * @return int
     */
    public function getDaysBack()
    {
        return $this->days_back;
    }

    /**
     * Generated from protobuf field <code>int32 days_back = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setDaysBack($var)
    {
        GPBUtil::checkInt32($var);
        $this->days_back = $var;

        return $this;
    }

}

