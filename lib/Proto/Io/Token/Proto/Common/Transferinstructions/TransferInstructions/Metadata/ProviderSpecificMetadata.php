<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transferinstructions.proto

namespace Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.transferinstructions.TransferInstructions.Metadata.ProviderSpecificMetadata</code>
 */
class ProviderSpecificMetadata extends \Google\Protobuf\Internal\Message
{
    protected $provider_metadata;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata\ProviderSpecificMetadata\PolishApiMetadata $polish_api_metadata
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transferinstructions::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata.ProviderSpecificMetadata.PolishApiMetadata polish_api_metadata = 1;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata\ProviderSpecificMetadata\PolishApiMetadata
     */
    public function getPolishApiMetadata()
    {
        return $this->readOneof(1);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferInstructions.Metadata.ProviderSpecificMetadata.PolishApiMetadata polish_api_metadata = 1;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferInstructions\Metadata\ProviderSpecificMetadata\PolishApiMetadata $var
     * @return $this
     */
    public function setPolishApiMetadata($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferInstructions_Metadata_ProviderSpecificMetadata_PolishApiMetadata::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getProviderMetadata()
    {
        return $this->whichOneof("provider_metadata");
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ProviderSpecificMetadata::class, \Io\Token\Proto\Common\Transferinstructions\TransferInstructions_Metadata_ProviderSpecificMetadata::class);

