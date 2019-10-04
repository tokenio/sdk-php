<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.CurrencyRate</code>
 */
class CurrencyRate extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>double rate = 1;</code>
     */
    private $rate = 0.0;
    /**
     * Generated from protobuf field <code>string from_currency = 2;</code>
     */
    private $from_currency = '';
    /**
     * Generated from protobuf field <code>string to_currency = 3;</code>
     */
    private $to_currency = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $rate
     *     @type string $from_currency
     *     @type string $to_currency
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Provider\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>double rate = 1;</code>
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Generated from protobuf field <code>double rate = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setRate($var)
    {
        GPBUtil::checkDouble($var);
        $this->rate = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string from_currency = 2;</code>
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->from_currency;
    }

    /**
     * Generated from protobuf field <code>string from_currency = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setFromCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->from_currency = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string to_currency = 3;</code>
     * @return string
     */
    public function getToCurrency()
    {
        return $this->to_currency;
    }

    /**
     * Generated from protobuf field <code>string to_currency = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setToCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->to_currency = $var;

        return $this;
    }

}

