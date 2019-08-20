<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetNotificationsRequest</code>
 */
class GetNotificationsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * offset and limit
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 1;</code>
     */
    private $page = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Gateway\Page $page
     *           offset and limit
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * offset and limit
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 1;</code>
     * @return \Io\Token\Proto\Gateway\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * offset and limit
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 1;</code>
     * @param \Io\Token\Proto\Gateway\Page $var
     * @return $this
     */
    public function setPage($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Gateway\Page::class);
        $this->page = $var;

        return $this;
    }

}

