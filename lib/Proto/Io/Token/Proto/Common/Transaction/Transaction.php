<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transaction.proto

namespace Io\Token\Proto\Common\Transaction;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.transaction.Transaction</code>
 */
class Transaction extends \Google\Protobuf\Internal\Message
{
    /**
     * Transaction ID.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * Debit or credit
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionType type = 2;</code>
     */
    private $type = 0;
    /**
     * Status. For example, SUCCESS or FAILURE_CANCELED
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionStatus status = 3;</code>
     */
    private $status = 0;
    /**
     * Transaction amount.
     *
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 4;</code>
     */
    private $amount = null;
    /**
     * Optional description
     *
     * Generated from protobuf field <code>string description = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
     */
    private $description = '';
    /**
     * Points to the token, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_id = 6;</code>
     */
    private $token_id = '';
    /**
     * Points to the token transfer, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_transfer_id = 7;</code>
     */
    private $token_transfer_id = '';
    /**
     * Creation time
     *
     * Generated from protobuf field <code>int64 created_at_ms = 8;</code>
     */
    private $created_at_ms = 0;
    /**
     * Additional fields. Optional.
     *
     * Generated from protobuf field <code>map<string, string> metadata = 9 [(.io.token.proto.extensions.field.redact) = true];</code>
     */
    private $metadata;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderTransactionDetails provider_transaction_details = 10;</code>
     */
    private $provider_transaction_details = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint creditor_endpoint = 11;</code>
     */
    private $creditor_endpoint = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           Transaction ID.
     *     @type int $type
     *           Debit or credit
     *     @type int $status
     *           Status. For example, SUCCESS or FAILURE_CANCELED
     *     @type \Io\Token\Proto\Common\Money\Money $amount
     *           Transaction amount.
     *     @type string $description
     *           Optional description
     *     @type string $token_id
     *           Points to the token, only set for Token transactions.
     *     @type string $token_transfer_id
     *           Points to the token transfer, only set for Token transactions.
     *     @type int|string $created_at_ms
     *           Creation time
     *     @type array|\Google\Protobuf\Internal\MapField $metadata
     *           Additional fields. Optional.
     *     @type \Io\Token\Proto\Common\Providerspecific\ProviderTransactionDetails $provider_transaction_details
     *     @type \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint $creditor_endpoint
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transaction::initOnce();
        parent::__construct($data);
    }

    /**
     * Transaction ID.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Transaction ID.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Debit or credit
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionType type = 2;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Debit or credit
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionType type = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Transaction\TransactionType::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Status. For example, SUCCESS or FAILURE_CANCELED
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionStatus status = 3;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status. For example, SUCCESS or FAILURE_CANCELED
     *
     * Generated from protobuf field <code>.io.token.proto.common.transaction.TransactionStatus status = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Transaction\TransactionStatus::class);
        $this->status = $var;

        return $this;
    }

    /**
     * Transaction amount.
     *
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 4;</code>
     * @return \Io\Token\Proto\Common\Money\Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Transaction amount.
     *
     * Generated from protobuf field <code>.io.token.proto.common.money.Money amount = 4;</code>
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
     * Optional description
     *
     * Generated from protobuf field <code>string description = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Optional description
     *
     * Generated from protobuf field <code>string description = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
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
     * Points to the token, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_id = 6;</code>
     * @return string
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * Points to the token, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_id = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_id = $var;

        return $this;
    }

    /**
     * Points to the token transfer, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_transfer_id = 7;</code>
     * @return string
     */
    public function getTokenTransferId()
    {
        return $this->token_transfer_id;
    }

    /**
     * Points to the token transfer, only set for Token transactions.
     *
     * Generated from protobuf field <code>string token_transfer_id = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenTransferId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_transfer_id = $var;

        return $this;
    }

    /**
     * Creation time
     *
     * Generated from protobuf field <code>int64 created_at_ms = 8;</code>
     * @return int|string
     */
    public function getCreatedAtMs()
    {
        return $this->created_at_ms;
    }

    /**
     * Creation time
     *
     * Generated from protobuf field <code>int64 created_at_ms = 8;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCreatedAtMs($var)
    {
        GPBUtil::checkInt64($var);
        $this->created_at_ms = $var;

        return $this;
    }

    /**
     * Additional fields. Optional.
     *
     * Generated from protobuf field <code>map<string, string> metadata = 9 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Additional fields. Optional.
     *
     * Generated from protobuf field <code>map<string, string> metadata = 9 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setMetadata($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->metadata = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderTransactionDetails provider_transaction_details = 10;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\ProviderTransactionDetails
     */
    public function getProviderTransactionDetails()
    {
        return $this->provider_transaction_details;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderTransactionDetails provider_transaction_details = 10;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\ProviderTransactionDetails $var
     * @return $this
     */
    public function setProviderTransactionDetails($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\ProviderTransactionDetails::class);
        $this->provider_transaction_details = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint creditor_endpoint = 11;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint
     */
    public function getCreditorEndpoint()
    {
        return $this->creditor_endpoint;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.TransferEndpoint creditor_endpoint = 11;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint $var
     * @return $this
     */
    public function setCreditorEndpoint($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\TransferEndpoint::class);
        $this->creditor_endpoint = $var;

        return $this;
    }

}

