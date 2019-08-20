<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetTokenBlobRequest</code>
 */
class GetTokenBlobRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * ID of token to use for "permission"
     *
     * Generated from protobuf field <code>string token_id = 1;</code>
     */
    private $token_id = '';
    /**
     * ID of blob to fetch
     *
     * Generated from protobuf field <code>string blob_id = 2;</code>
     */
    private $blob_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $token_id
     *           ID of token to use for "permission"
     *     @type string $blob_id
     *           ID of blob to fetch
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * ID of token to use for "permission"
     *
     * Generated from protobuf field <code>string token_id = 1;</code>
     * @return string
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * ID of token to use for "permission"
     *
     * Generated from protobuf field <code>string token_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_id = $var;

        return $this;
    }

    /**
     * ID of blob to fetch
     *
     * Generated from protobuf field <code>string blob_id = 2;</code>
     * @return string
     */
    public function getBlobId()
    {
        return $this->blob_id;
    }

    /**
     * ID of blob to fetch
     *
     * Generated from protobuf field <code>string blob_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setBlobId($var)
    {
        GPBUtil::checkString($var, True);
        $this->blob_id = $var;

        return $this;
    }

}

