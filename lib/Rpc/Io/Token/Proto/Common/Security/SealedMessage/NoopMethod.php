<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: security.proto

namespace Io\Token\Proto\Common\Security\SealedMessage;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Clear text is used instead of encryption
 *
 * Generated from protobuf message <code>io.token.proto.common.security.SealedMessage.NoopMethod</code>
 */
class NoopMethod extends \Google\Protobuf\Internal\Message
{

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Security::initOnce();
        parent::__construct($data);
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(NoopMethod::class, \Io\Token\Proto\Common\Security\SealedMessage_NoopMethod::class);

