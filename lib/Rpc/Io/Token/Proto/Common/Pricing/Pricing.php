<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: pricing.proto

namespace Io\Token\Proto\Common\Pricing;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.pricing.Pricing</code>
 */
class Pricing extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote source_quote = 1;</code>
     */
    private $source_quote = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote destination_quote = 2;</code>
     */
    private $destination_quote = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.PricingInstructions instructions = 3;</code>
     */
    private $instructions = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Pricing\TransferQuote $source_quote
     *     @type \Io\Token\Proto\Common\Pricing\TransferQuote $destination_quote
     *     @type \Io\Token\Proto\Common\Pricing\PricingInstructions $instructions
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Pricing::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote source_quote = 1;</code>
     * @return \Io\Token\Proto\Common\Pricing\TransferQuote
     */
    public function getSourceQuote()
    {
        return $this->source_quote;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote source_quote = 1;</code>
     * @param \Io\Token\Proto\Common\Pricing\TransferQuote $var
     * @return $this
     */
    public function setSourceQuote($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Pricing\TransferQuote::class);
        $this->source_quote = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote destination_quote = 2;</code>
     * @return \Io\Token\Proto\Common\Pricing\TransferQuote
     */
    public function getDestinationQuote()
    {
        return $this->destination_quote;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.TransferQuote destination_quote = 2;</code>
     * @param \Io\Token\Proto\Common\Pricing\TransferQuote $var
     * @return $this
     */
    public function setDestinationQuote($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Pricing\TransferQuote::class);
        $this->destination_quote = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.PricingInstructions instructions = 3;</code>
     * @return \Io\Token\Proto\Common\Pricing\PricingInstructions
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.pricing.PricingInstructions instructions = 3;</code>
     * @param \Io\Token\Proto\Common\Pricing\PricingInstructions $var
     * @return $this
     */
    public function setInstructions($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Pricing\PricingInstructions::class);
        $this->instructions = $var;

        return $this;
    }

}

