<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transferinstructions.proto

namespace Io\Token\Proto\Common\Transferinstructions\TransferDestination;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * SEPA transfer
 *
 * Generated from protobuf message <code>io.token.proto.common.transferinstructions.TransferDestination.Sepa</code>
 */
class Sepa extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     */
    private $bic = '';
    /**
     * Generated from protobuf field <code>string iban = 2;</code>
     */
    private $iban = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bic
     *           Optional
     *     @type string $iban
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transferinstructions::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * Optional
     *
     * Generated from protobuf field <code>string bic = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBic($var)
    {
        GPBUtil::checkString($var, True);
        $this->bic = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string iban = 2;</code>
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Generated from protobuf field <code>string iban = 2;</code>
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
class_alias(Sepa::class, \Io\Token\Proto\Common\Transferinstructions\TransferDestination_Sepa::class);

