<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: notification.proto

namespace Io\Token\Proto\Common\Notification;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A notification that a token was cancelled
 *
 * Generated from protobuf message <code>io.token.proto.common.notification.TokenCancelled</code>
 */
class TokenCancelled extends \Google\Protobuf\Internal\Message
{
    /**
     * Token ID
     *
     * Generated from protobuf field <code>string token_id = 1;</code>
     */
    private $token_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $token_id
     *           Token ID
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Notification::initOnce();
        parent::__construct($data);
    }

    /**
     * Token ID
     *
     * Generated from protobuf field <code>string token_id = 1;</code>
     * @return string
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * Token ID
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

}

