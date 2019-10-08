<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.TransactionInfoCard</code>
 */
class TransactionInfoCard extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string card_holder = 1;</code>
     */
    private $card_holder = '';
    /**
     * Generated from protobuf field <code>string card_number = 2;</code>
     */
    private $card_number = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $card_holder
     *     @type string $card_number
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Provider\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string card_holder = 1;</code>
     * @return string
     */
    public function getCardHolder()
    {
        return $this->card_holder;
    }

    /**
     * Generated from protobuf field <code>string card_holder = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCardHolder($var)
    {
        GPBUtil::checkString($var, True);
        $this->card_holder = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string card_number = 2;</code>
     * @return string
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * Generated from protobuf field <code>string card_number = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCardNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->card_number = $var;

        return $this;
    }

}
