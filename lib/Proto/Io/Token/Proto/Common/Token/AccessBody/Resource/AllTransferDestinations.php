<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\AccessBody\Resource;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Provides access to the resolved transfer destinations of all accounts
 *
 * Generated from protobuf message <code>io.token.proto.common.token.AccessBody.Resource.AllTransferDestinations</code>
 */
class AllTransferDestinations extends \Google\Protobuf\Internal\Message
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
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AllTransferDestinations::class, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllTransferDestinations::class);
