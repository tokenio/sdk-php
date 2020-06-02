<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetTppAccessReportResponse</code>
 */
class GetTppAccessReportResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetTppAccessReportResponse.TppAccessSummary summaries = 1;</code>
     */
    private $summaries;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Gateway\GetTppAccessReportResponse\TppAccessSummary[]|\Google\Protobuf\Internal\RepeatedField $summaries
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetTppAccessReportResponse.TppAccessSummary summaries = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSummaries()
    {
        return $this->summaries;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetTppAccessReportResponse.TppAccessSummary summaries = 1;</code>
     * @param \Io\Token\Proto\Gateway\GetTppAccessReportResponse\TppAccessSummary[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSummaries($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Gateway\GetTppAccessReportResponse\TppAccessSummary::class);
        $this->summaries = $arr;

        return $this;
    }

}

