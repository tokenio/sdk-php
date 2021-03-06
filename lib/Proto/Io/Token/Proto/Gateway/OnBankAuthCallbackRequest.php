<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.OnBankAuthCallbackRequest</code>
 */
class OnBankAuthCallbackRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * the bank id of the callback. Typically extracted from the path component of the callback url
     *
     * Generated from protobuf field <code>string bank_id = 1;</code>
     */
    private $bank_id = '';
    /**
     * the query component of the callback url
     *
     * Generated from protobuf field <code>string query = 2;</code>
     */
    private $query = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bank_id
     *           the bank id of the callback. Typically extracted from the path component of the callback url
     *     @type string $query
     *           the query component of the callback url
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * the bank id of the callback. Typically extracted from the path component of the callback url
     *
     * Generated from protobuf field <code>string bank_id = 1;</code>
     * @return string
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * the bank id of the callback. Typically extracted from the path component of the callback url
     *
     * Generated from protobuf field <code>string bank_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBankId($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_id = $var;

        return $this;
    }

    /**
     * the query component of the callback url
     *
     * Generated from protobuf field <code>string query = 2;</code>
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * the query component of the callback url
     *
     * Generated from protobuf field <code>string query = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setQuery($var)
    {
        GPBUtil::checkString($var, True);
        $this->query = $var;

        return $this;
    }

}

