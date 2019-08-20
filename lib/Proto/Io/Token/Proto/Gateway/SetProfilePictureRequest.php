<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.SetProfilePictureRequest</code>
 */
class SetProfilePictureRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * image "file"
     *
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload payload = 1;</code>
     */
    private $payload = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Blob\Blob\Payload $payload
     *           image "file"
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * image "file"
     *
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload payload = 1;</code>
     * @return \Io\Token\Proto\Common\Blob\Blob\Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * image "file"
     *
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload payload = 1;</code>
     * @param \Io\Token\Proto\Common\Blob\Blob\Payload $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Blob\Blob_Payload::class);
        $this->payload = $var;

        return $this;
    }

}

