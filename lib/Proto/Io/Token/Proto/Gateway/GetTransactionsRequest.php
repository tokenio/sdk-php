<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetTransactionsRequest</code>
 */
class GetTransactionsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string account_id = 1;</code>
     */
    private $account_id = '';
    /**
     * Optional paging settings.
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 2;</code>
     */
    private $page = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $account_id
     *     @type \Io\Token\Proto\Gateway\Page $page
     *           Optional paging settings.
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string account_id = 1;</code>
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Generated from protobuf field <code>string account_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setAccountId($var)
    {
        GPBUtil::checkString($var, True);
        $this->account_id = $var;

        return $this;
    }

    /**
     * Optional paging settings.
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 2;</code>
     * @return \Io\Token\Proto\Gateway\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Optional paging settings.
     *
     * Generated from protobuf field <code>.io.token.proto.gateway.Page page = 2;</code>
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

