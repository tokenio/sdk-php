<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transferinstructions.proto

namespace Io\Token\Proto\Common\Transferinstructions\TransferDestination;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.transferinstructions.TransferDestination.SepaInstant</code>
 */
class SepaInstant extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string iban = 1;</code>
     */
    private $iban = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $iban
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transferinstructions::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string iban = 1;</code>
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Generated from protobuf field <code>string iban = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setIban($var)
    {
        GPBUtil::checkString($var, True);
        $this->iban = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SepaInstant::class, \Io\Token\Proto\Common\Transferinstructions\TransferDestination_SepaInstant::class);

