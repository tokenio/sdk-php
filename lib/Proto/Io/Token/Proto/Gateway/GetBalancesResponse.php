<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetBalancesResponse</code>
 */
class GetBalancesResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBalanceResponse response = 1;</code>
     */
    private $response;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Gateway\GetBalanceResponse[]|\Google\Protobuf\Internal\RepeatedField $response
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBalanceResponse response = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.gateway.GetBalanceResponse response = 1;</code>
     * @param \Io\Token\Proto\Gateway\GetBalanceResponse[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setResponse($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Gateway\GetBalanceResponse::class);
        $this->response = $arr;

        return $this;
    }

}

