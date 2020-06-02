<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: bankinfo.proto

namespace Io\Token\Proto\Common\Bank\BankFilter;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.bank.BankFilter.BankFeatures</code>
 */
class BankFeatures extends \Google\Protobuf\Internal\Message
{
    /**
     * Works with appless payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_appless = 1 [deprecated = true];</code>
     */
    private $supports_appless = null;
    /**
     * Connection supports guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_guest_checkout = 2;</code>
     */
    private $supports_guest_checkout = null;
    /**
     * Connection allows for retrieval of information
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_information = 3;</code>
     */
    private $supports_information = null;
    /**
     * Connection requires external authorization for creating transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_external_auth = 4;</code>
     */
    private $requires_external_auth = null;
    /**
     * Connection allows for payment initiation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_send_payment = 5;</code>
     */
    private $supports_send_payment = null;
    /**
     * Connection allows for receiving payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_receive_payment = 6;</code>
     */
    private $supports_receive_payment = null;
    /**
     * Connection allows for retrieving balances
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_balance = 7;</code>
     */
    private $supports_balance = null;
    /**
     * Connection supports scheduled payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_scheduled_payment = 8;</code>
     */
    private $supports_scheduled_payment = null;
    /**
     * Connection supports standing orders
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_standing_order = 9;</code>
     */
    private $supports_standing_order = null;
    /**
     * Connection supports bulk payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_bulk_transfer = 10;</code>
     */
    private $supports_bulk_transfer = null;
    /**
     * Connection only supports immediate redemption of transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_one_step_payment = 11;</code>
     */
    private $requires_one_step_payment = null;
    /**
     * Connection supports linking with a bank linking URI
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_linking_uri = 12;</code>
     */
    private $supports_linking_uri = null;
    /**
     * Connection allows ais guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_ais_guest_checkout = 13;</code>
     */
    private $supports_ais_guest_checkout = null;
    /**
     * Connection supports funds confirmation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_funds_confirmation = 14;</code>
     */
    private $supports_funds_confirmation = null;
    /**
     * Connection supports checkout flow v2
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_checkout_flow_v2 = 15;</code>
     */
    private $supports_checkout_flow_v2 = null;
    /**
     * Connection requires source account
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_source_account = 16;</code>
     */
    private $requires_source_account = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\BoolValue $supports_appless
     *           Works with appless payments
     *     @type \Google\Protobuf\BoolValue $supports_guest_checkout
     *           Connection supports guest checkout
     *     @type \Google\Protobuf\BoolValue $supports_information
     *           Connection allows for retrieval of information
     *     @type \Google\Protobuf\BoolValue $requires_external_auth
     *           Connection requires external authorization for creating transfers
     *     @type \Google\Protobuf\BoolValue $supports_send_payment
     *           Connection allows for payment initiation
     *     @type \Google\Protobuf\BoolValue $supports_receive_payment
     *           Connection allows for receiving payments
     *     @type \Google\Protobuf\BoolValue $supports_balance
     *           Connection allows for retrieving balances
     *     @type \Google\Protobuf\BoolValue $supports_scheduled_payment
     *           Connection supports scheduled payments
     *     @type \Google\Protobuf\BoolValue $supports_standing_order
     *           Connection supports standing orders
     *     @type \Google\Protobuf\BoolValue $supports_bulk_transfer
     *           Connection supports bulk payments
     *     @type \Google\Protobuf\BoolValue $requires_one_step_payment
     *           Connection only supports immediate redemption of transfers
     *     @type \Google\Protobuf\BoolValue $supports_linking_uri
     *           Connection supports linking with a bank linking URI
     *     @type \Google\Protobuf\BoolValue $supports_ais_guest_checkout
     *           Connection allows ais guest checkout
     *     @type \Google\Protobuf\BoolValue $supports_funds_confirmation
     *           Connection supports funds confirmation
     *     @type \Google\Protobuf\BoolValue $supports_checkout_flow_v2
     *           Connection supports checkout flow v2
     *     @type \Google\Protobuf\BoolValue $requires_source_account
     *           Connection requires source account
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Bankinfo::initOnce();
        parent::__construct($data);
    }

    /**
     * Works with appless payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_appless = 1 [deprecated = true];</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsAppless()
    {
        return $this->supports_appless;
    }

    /**
     * Works with appless payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_appless = 1 [deprecated = true];</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsAppless($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_appless = $var;

        return $this;
    }

    /**
     * Connection supports guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_guest_checkout = 2;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsGuestCheckout()
    {
        return $this->supports_guest_checkout;
    }

    /**
     * Connection supports guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_guest_checkout = 2;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsGuestCheckout($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_guest_checkout = $var;

        return $this;
    }

    /**
     * Connection allows for retrieval of information
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_information = 3;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsInformation()
    {
        return $this->supports_information;
    }

    /**
     * Connection allows for retrieval of information
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_information = 3;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsInformation($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_information = $var;

        return $this;
    }

    /**
     * Connection requires external authorization for creating transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_external_auth = 4;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getRequiresExternalAuth()
    {
        return $this->requires_external_auth;
    }

    /**
     * Connection requires external authorization for creating transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_external_auth = 4;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setRequiresExternalAuth($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->requires_external_auth = $var;

        return $this;
    }

    /**
     * Connection allows for payment initiation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_send_payment = 5;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsSendPayment()
    {
        return $this->supports_send_payment;
    }

    /**
     * Connection allows for payment initiation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_send_payment = 5;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsSendPayment($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_send_payment = $var;

        return $this;
    }

    /**
     * Connection allows for receiving payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_receive_payment = 6;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsReceivePayment()
    {
        return $this->supports_receive_payment;
    }

    /**
     * Connection allows for receiving payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_receive_payment = 6;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsReceivePayment($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_receive_payment = $var;

        return $this;
    }

    /**
     * Connection allows for retrieving balances
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_balance = 7;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsBalance()
    {
        return $this->supports_balance;
    }

    /**
     * Connection allows for retrieving balances
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_balance = 7;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsBalance($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_balance = $var;

        return $this;
    }

    /**
     * Connection supports scheduled payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_scheduled_payment = 8;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsScheduledPayment()
    {
        return $this->supports_scheduled_payment;
    }

    /**
     * Connection supports scheduled payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_scheduled_payment = 8;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsScheduledPayment($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_scheduled_payment = $var;

        return $this;
    }

    /**
     * Connection supports standing orders
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_standing_order = 9;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsStandingOrder()
    {
        return $this->supports_standing_order;
    }

    /**
     * Connection supports standing orders
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_standing_order = 9;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsStandingOrder($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_standing_order = $var;

        return $this;
    }

    /**
     * Connection supports bulk payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_bulk_transfer = 10;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsBulkTransfer()
    {
        return $this->supports_bulk_transfer;
    }

    /**
     * Connection supports bulk payments
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_bulk_transfer = 10;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsBulkTransfer($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_bulk_transfer = $var;

        return $this;
    }

    /**
     * Connection only supports immediate redemption of transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_one_step_payment = 11;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getRequiresOneStepPayment()
    {
        return $this->requires_one_step_payment;
    }

    /**
     * Connection only supports immediate redemption of transfers
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_one_step_payment = 11;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setRequiresOneStepPayment($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->requires_one_step_payment = $var;

        return $this;
    }

    /**
     * Connection supports linking with a bank linking URI
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_linking_uri = 12;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsLinkingUri()
    {
        return $this->supports_linking_uri;
    }

    /**
     * Connection supports linking with a bank linking URI
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_linking_uri = 12;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsLinkingUri($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_linking_uri = $var;

        return $this;
    }

    /**
     * Connection allows ais guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_ais_guest_checkout = 13;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsAisGuestCheckout()
    {
        return $this->supports_ais_guest_checkout;
    }

    /**
     * Connection allows ais guest checkout
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_ais_guest_checkout = 13;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsAisGuestCheckout($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_ais_guest_checkout = $var;

        return $this;
    }

    /**
     * Connection supports funds confirmation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_funds_confirmation = 14;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsFundsConfirmation()
    {
        return $this->supports_funds_confirmation;
    }

    /**
     * Connection supports funds confirmation
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_funds_confirmation = 14;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsFundsConfirmation($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_funds_confirmation = $var;

        return $this;
    }

    /**
     * Connection supports checkout flow v2
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_checkout_flow_v2 = 15;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getSupportsCheckoutFlowV2()
    {
        return $this->supports_checkout_flow_v2;
    }

    /**
     * Connection supports checkout flow v2
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue supports_checkout_flow_v2 = 15;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setSupportsCheckoutFlowV2($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->supports_checkout_flow_v2 = $var;

        return $this;
    }

    /**
     * Connection requires source account
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_source_account = 16;</code>
     * @return \Google\Protobuf\BoolValue
     */
    public function getRequiresSourceAccount()
    {
        return $this->requires_source_account;
    }

    /**
     * Connection requires source account
     *
     * Generated from protobuf field <code>.google.protobuf.BoolValue requires_source_account = 16;</code>
     * @param \Google\Protobuf\BoolValue $var
     * @return $this
     */
    public function setRequiresSourceAccount($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\BoolValue::class);
        $this->requires_source_account = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(BankFeatures::class, \Io\Token\Proto\Common\Bank\BankFilter_BankFeatures::class);

