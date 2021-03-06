<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\BulkTransferBody;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.token.BulkTransferBody.Transfer</code>
 */
class Transfer extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string amount = 1;</code>
     */
    private $amount = '';
    /**
     * Generated from protobuf field <code>string currency = 2;</code>
     */
    private $currency = '';
    /**
     * Generated from protobuf field <code>string ref_id = 3;</code>
     */
    private $ref_id = '';
    /**
     * Generated from protobuf field <code>string description = 4;</code>
     */
    private $description = '';
    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferDestination destination = 5;</code>
     */
    private $destination = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 6;</code>
     */
    private $metadata = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $amount
     *     @type string $currency
     *     @type string $ref_id
     *     @type string $description
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferDestination $destination
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata $metadata
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string amount = 1;</code>
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Generated from protobuf field <code>string amount = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setAmount($var)
    {
        GPBUtil::checkString($var, True);
        $this->amount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string currency = 2;</code>
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Generated from protobuf field <code>string currency = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->currency = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string ref_id = 3;</code>
     * @return string
     */
    public function getRefId()
    {
        return $this->ref_id;
    }

    /**
     * Generated from protobuf field <code>string ref_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setRefId($var)
    {
        GPBUtil::checkString($var, True);
        $this->ref_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string description = 4;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Generated from protobuf field <code>string description = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferDestination destination = 5;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferDestination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferDestination destination = 5;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferDestination $var
     * @return $this
     */
    public function setDestination($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferDestination::class);
        $this->destination = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 6;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 6;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata $var
     * @return $this
     */
    public function setMetadata($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferInstructions_Metadata::class);
        $this->metadata = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Transfer::class, \Io\Token\Proto\Common\Token\BulkTransferBody_Transfer::class);

