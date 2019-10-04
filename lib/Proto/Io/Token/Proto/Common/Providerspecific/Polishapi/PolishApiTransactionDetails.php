<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/polishapi.proto

namespace Io\Token\Proto\Common\Providerspecific\Polishapi;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.providerspecific.polishapi.PolishApiTransactionDetails</code>
 */
class PolishApiTransactionDetails extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string transaction_type = 1;</code>
     */
    private $transaction_type = '';
    /**
     * Generated from protobuf field <code>string mcc = 2;</code>
     */
    private $mcc = '';
    /**
     * Generated from protobuf field <code>map<string, string> auxData = 3;</code>
     */
    private $auxData;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.NameAddress initiator = 4;</code>
     */
    private $initiator = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient sender = 5;</code>
     */
    private $sender = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient recipient = 6;</code>
     */
    private $recipient = null;
    /**
     * Generated from protobuf field <code>string trade_date = 7;</code>
     */
    private $trade_date = '';
    /**
     * Generated from protobuf field <code>string post_transaction_balance = 8;</code>
     */
    private $post_transaction_balance = '';
    /**
     * Generated from protobuf field <code>string rejection_date = 9;</code>
     */
    private $rejection_date = '';
    /**
     * Generated from protobuf field <code>string rejection_reason = 10;</code>
     */
    private $rejection_reason = '';
    /**
     * from Polish API getTransactionDetail endpoint
     *
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoZus zus_info = 11;</code>
     */
    private $zus_info = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoTax tax_info = 12;</code>
     */
    private $tax_info = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoCard card_info = 13;</code>
     */
    private $card_info = null;
    /**
     * Generated from protobuf field <code>string currency_date = 14;</code>
     */
    private $currency_date = '';
    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.providerspecific.polishapi.CurrencyRate transaction_rate = 15;</code>
     */
    private $transaction_rate;
    /**
     * Generated from protobuf field <code>string base_currency = 16;</code>
     */
    private $base_currency = '';
    /**
     * Generated from protobuf field <code>string account_base_currency = 17;</code>
     */
    private $account_base_currency = '';
    /**
     * Generated from protobuf field <code>string used_payment_instrument_id = 18;</code>
     */
    private $used_payment_instrument_id = '';
    /**
     * Generated from protobuf field <code>string tpp_transaction_id = 19;</code>
     */
    private $tpp_transaction_id = '';
    /**
     * Generated from protobuf field <code>string tpp_name = 20;</code>
     */
    private $tpp_name = '';
    /**
     * Generated from protobuf field <code>string hold_expiration_date = 21;</code>
     */
    private $hold_expiration_date = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $transaction_type
     *     @type string $mcc
     *     @type array|\Google\Protobuf\Internal\MapField $auxData
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\NameAddress $initiator
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient $sender
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient $recipient
     *     @type string $trade_date
     *     @type string $post_transaction_balance
     *     @type string $rejection_date
     *     @type string $rejection_reason
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoZus $zus_info
     *           from Polish API getTransactionDetail endpoint
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoTax $tax_info
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoCard $card_info
     *     @type string $currency_date
     *     @type \Io\Token\Proto\Common\Providerspecific\Polishapi\CurrencyRate[]|\Google\Protobuf\Internal\RepeatedField $transaction_rate
     *     @type string $base_currency
     *     @type string $account_base_currency
     *     @type string $used_payment_instrument_id
     *     @type string $tpp_transaction_id
     *     @type string $tpp_name
     *     @type string $hold_expiration_date
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Provider\Polishapi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string transaction_type = 1;</code>
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transaction_type;
    }

    /**
     * Generated from protobuf field <code>string transaction_type = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTransactionType($var)
    {
        GPBUtil::checkString($var, True);
        $this->transaction_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string mcc = 2;</code>
     * @return string
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * Generated from protobuf field <code>string mcc = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setMcc($var)
    {
        GPBUtil::checkString($var, True);
        $this->mcc = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>map<string, string> auxData = 3;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getAuxData()
    {
        return $this->auxData;
    }

    /**
     * Generated from protobuf field <code>map<string, string> auxData = 3;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setAuxData($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->auxData = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.NameAddress initiator = 4;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\NameAddress
     */
    public function getInitiator()
    {
        return $this->initiator;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.NameAddress initiator = 4;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\NameAddress $var
     * @return $this
     */
    public function setInitiator($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\NameAddress::class);
        $this->initiator = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient sender = 5;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient sender = 5;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient $var
     * @return $this
     */
    public function setSender($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient::class);
        $this->sender = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient recipient = 6;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.SenderRecipient recipient = 6;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient $var
     * @return $this
     */
    public function setRecipient($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\SenderRecipient::class);
        $this->recipient = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string trade_date = 7;</code>
     * @return string
     */
    public function getTradeDate()
    {
        return $this->trade_date;
    }

    /**
     * Generated from protobuf field <code>string trade_date = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setTradeDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->trade_date = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string post_transaction_balance = 8;</code>
     * @return string
     */
    public function getPostTransactionBalance()
    {
        return $this->post_transaction_balance;
    }

    /**
     * Generated from protobuf field <code>string post_transaction_balance = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setPostTransactionBalance($var)
    {
        GPBUtil::checkString($var, True);
        $this->post_transaction_balance = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string rejection_date = 9;</code>
     * @return string
     */
    public function getRejectionDate()
    {
        return $this->rejection_date;
    }

    /**
     * Generated from protobuf field <code>string rejection_date = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setRejectionDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->rejection_date = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string rejection_reason = 10;</code>
     * @return string
     */
    public function getRejectionReason()
    {
        return $this->rejection_reason;
    }

    /**
     * Generated from protobuf field <code>string rejection_reason = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setRejectionReason($var)
    {
        GPBUtil::checkString($var, True);
        $this->rejection_reason = $var;

        return $this;
    }

    /**
     * from Polish API getTransactionDetail endpoint
     *
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoZus zus_info = 11;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoZus
     */
    public function getZusInfo()
    {
        return $this->zus_info;
    }

    /**
     * from Polish API getTransactionDetail endpoint
     *
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoZus zus_info = 11;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoZus $var
     * @return $this
     */
    public function setZusInfo($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoZus::class);
        $this->zus_info = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoTax tax_info = 12;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoTax
     */
    public function getTaxInfo()
    {
        return $this->tax_info;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoTax tax_info = 12;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoTax $var
     * @return $this
     */
    public function setTaxInfo($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoTax::class);
        $this->tax_info = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoCard card_info = 13;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoCard
     */
    public function getCardInfo()
    {
        return $this->card_info;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.polishapi.TransactionInfoCard card_info = 13;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoCard $var
     * @return $this
     */
    public function setCardInfo($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\Polishapi\TransactionInfoCard::class);
        $this->card_info = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string currency_date = 14;</code>
     * @return string
     */
    public function getCurrencyDate()
    {
        return $this->currency_date;
    }

    /**
     * Generated from protobuf field <code>string currency_date = 14;</code>
     * @param string $var
     * @return $this
     */
    public function setCurrencyDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->currency_date = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.providerspecific.polishapi.CurrencyRate transaction_rate = 15;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTransactionRate()
    {
        return $this->transaction_rate;
    }

    /**
     * Generated from protobuf field <code>repeated .io.token.proto.common.providerspecific.polishapi.CurrencyRate transaction_rate = 15;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\Polishapi\CurrencyRate[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTransactionRate($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Providerspecific\Polishapi\CurrencyRate::class);
        $this->transaction_rate = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string base_currency = 16;</code>
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->base_currency;
    }

    /**
     * Generated from protobuf field <code>string base_currency = 16;</code>
     * @param string $var
     * @return $this
     */
    public function setBaseCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->base_currency = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string account_base_currency = 17;</code>
     * @return string
     */
    public function getAccountBaseCurrency()
    {
        return $this->account_base_currency;
    }

    /**
     * Generated from protobuf field <code>string account_base_currency = 17;</code>
     * @param string $var
     * @return $this
     */
    public function setAccountBaseCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->account_base_currency = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string used_payment_instrument_id = 18;</code>
     * @return string
     */
    public function getUsedPaymentInstrumentId()
    {
        return $this->used_payment_instrument_id;
    }

    /**
     * Generated from protobuf field <code>string used_payment_instrument_id = 18;</code>
     * @param string $var
     * @return $this
     */
    public function setUsedPaymentInstrumentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->used_payment_instrument_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string tpp_transaction_id = 19;</code>
     * @return string
     */
    public function getTppTransactionId()
    {
        return $this->tpp_transaction_id;
    }

    /**
     * Generated from protobuf field <code>string tpp_transaction_id = 19;</code>
     * @param string $var
     * @return $this
     */
    public function setTppTransactionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->tpp_transaction_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string tpp_name = 20;</code>
     * @return string
     */
    public function getTppName()
    {
        return $this->tpp_name;
    }

    /**
     * Generated from protobuf field <code>string tpp_name = 20;</code>
     * @param string $var
     * @return $this
     */
    public function setTppName($var)
    {
        GPBUtil::checkString($var, True);
        $this->tpp_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string hold_expiration_date = 21;</code>
     * @return string
     */
    public function getHoldExpirationDate()
    {
        return $this->hold_expiration_date;
    }

    /**
     * Generated from protobuf field <code>string hold_expiration_date = 21;</code>
     * @param string $var
     * @return $this
     */
    public function setHoldExpirationDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->hold_expiration_date = $var;

        return $this;
    }

}

