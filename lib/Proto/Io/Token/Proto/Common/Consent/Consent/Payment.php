<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: consent.proto

namespace Io\Token\Proto\Common\Consent\Consent;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.consent.Consent.Payment</code>
 */
class Payment extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.account.BankAccount account = 1;</code>
     */
    private $account = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money lifetime_amount = 2;</code>
     */
    private $lifetime_amount = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 3;</code>
     */
    private $amount = null;
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 4 [deprecated = true];</code>
     */
    private $destinations;
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 5;</code>
     */
    private $transfer_destinations;
    /**
     * Generated from protobuf field <code>string remittance_reference = 6 [(.io.token.proto.extensions.field.hash) = true];</code>
     */
    private $remittance_reference = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Account\BankAccount $account
     *     @type \Io\Token\Proto\Common\Money\Money $lifetime_amount
     *     @type \Io\Token\Proto\Common\Money\Money $amount
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint[]|\Google\Protobuf\Internal\RepeatedField $destinations
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferDestination[]|\Google\Protobuf\Internal\RepeatedField $transfer_destinations
     *     @type string $remittance_reference
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Consent::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.account.BankAccount account = 1;</code>
     * @return \Io\Token\Proto\Common\Account\BankAccount
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.account.BankAccount account = 1;</code>
     * @param \Io\Token\Proto\Common\Account\BankAccount $var
     * @return $this
     */
    public function setAccount($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Account\BankAccount::class);
        $this->account = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money lifetime_amount = 2;</code>
     * @return \Io\Token\Proto\Common\Money\Money
     */
    public function getLifetimeAmount()
    {
        return $this->lifetime_amount;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money lifetime_amount = 2;</code>
     * @param \Io\Token\Proto\Common\Money\Money $var
     * @return $this
     */
    public function setLifetimeAmount($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Money\Money::class);
        $this->lifetime_amount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 3;</code>
     * @return \Io\Token\Proto\Common\Money\Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 3;</code>
     * @param \Io\Token\Proto\Common\Money\Money $var
     * @return $this
     */
    public function setAmount($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Money\Money::class);
        $this->amount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 4 [deprecated = true];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferEndpoint destinations = 4 [deprecated = true];</code>
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
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTransferDestinations()
    {
        return $this->transfer_destinations;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.transferinstructions.TransferDestination transfer_destinations = 5;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferDestination[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTransferDestinations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Transferinstructions\TransferDestination::class);
        $this->transfer_destinations = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string remittance_reference = 6 [(.io.token.proto.extensions.field.hash) = true];</code>
     * @return string
     */
    public function getRemittanceReference()
    {
        return $this->remittance_reference;
    }

    /**
     * Generated from protobuf field <code>string remittance_reference = 6 [(.io.token.proto.extensions.field.hash) = true];</code>
     * @param string $var
     * @return $this
     */
    public function setRemittanceReference($var)
    {
        GPBUtil::checkString($var, True);
        $this->remittance_reference = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Payment::class, \Io\Token\Proto\Common\Consent\Consent_Payment::class);

