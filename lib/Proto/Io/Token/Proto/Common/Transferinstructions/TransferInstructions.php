<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transferinstructions.proto

namespace Io\Token\Proto\Common\Transferinstructions;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Money transfer instructions.
 *
 * Generated from protobuf message <code>io.token.proto.common.transferinstructions.TransferInstructions</code>
 */
class TransferInstructions extends \Google\Protobuf\Internal\Message
{
    /**
     * Transfer source.
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint source = 1;</code>
     */
    private $source = null;
    /**
     * Transfer destinations.
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 2 [deprecated = true];</code>
     */
    private $destinations;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 3;</code>
     */
    private $metadata = null;
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 4;</code>
     */
    private $transfer_destinations;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint $source
     *           Transfer source.
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint[]|\Google\Protobuf\Internal\RepeatedField $destinations
     *           Transfer destinations.
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata $metadata
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferDestination[]|\Google\Protobuf\Internal\RepeatedField $transfer_destinations
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transferinstructions::initOnce();
        parent::__construct($data);
    }

    /**
     * Transfer source.
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint source = 1;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Transfer source.
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint source = 1;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint $var
     * @return $this
     */
    public function setSource($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint::class);
        $this->source = $var;

        return $this;
    }

    /**
     * Transfer destinations.
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 2 [deprecated = true];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Transfer destinations.
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 2 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDestinations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint::class);
        $this->destinations = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 3;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata metadata = 3;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata $var
     * @return $this
     */
    public function setMetadata($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferInstructions_Metadata::class);
        $this->metadata = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTransferDestinations()
    {
        return $this->transfer_destinations;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 4;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferDestination[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTransferDestinations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Transferinstructions\TransferDestination::class);
        $this->transfer_destinations = $arr;

        return $this;
    }

}

