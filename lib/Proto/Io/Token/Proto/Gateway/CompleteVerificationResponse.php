<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.CompleteVerificationResponse</code>
 */
class CompleteVerificationResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.alias.VerificationStatus status = 1;</code>
     */
    private $status = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $status
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.alias.VerificationStatus status = 1;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.alias.VerificationStatus status = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Alias\VerificationStatus::class);
        $this->status = $var;

        return $this;
    }

}

