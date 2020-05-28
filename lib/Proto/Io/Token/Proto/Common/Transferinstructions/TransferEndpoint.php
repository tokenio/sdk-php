<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transferinstructions.proto

namespace Io\Token\Proto\Common\Transferinstructions;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Money transfer source or destination account.
 *
 * Generated from protobuf message <code>io.token.proto.common.transferinstructions.TransferEndpoint</code>
 */
class TransferEndpoint extends \Google\Protobuf\Internal\Message
{
    /**
     * Account identifier, e.g., SWIFT transfer info
     *
     * Generated from protobuf field <code>.io.token.proto.common.account.BankAccount account = 1;</code>
     */
    private $account = null;
    /**
     * Customer data: name and address
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.CustomerData customer_data = 2;</code>
     */
    private $customer_data = null;
    /**
     * Generated from protobuf field <code>string bank_id = 3;</code>
     */
    private $bank_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Account\BankAccount $account
     *           Account identifier, e.g., SWIFT transfer info
     *     @type \Io\Token\Proto\Common\Transferinstructions\CustomerData $customer_data
     *           Customer data: name and address
     *     @type string $bank_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Transferinstructions::initOnce();
        parent::__construct($data);
    }

    /**
     * Account identifier, e.g., SWIFT transfer info
     *
     * Generated from protobuf field <code>.io.token.proto.common.account.BankAccount account = 1;</code>
     * @return \Io\Token\Proto\Common\Account\BankAccount
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Account identifier, e.g., SWIFT transfer info
     *
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
     * Customer data: name and address
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.CustomerData customer_data = 2;</code>
     * @return \Io\Token\Proto\Common\Transferinstructions\CustomerData
     */
    public function getCustomerData()
    {
        return $this->customer_data;
    }

    /**
     * Customer data: name and address
     *
     * Generated from protobuf field <code>.io.token.proto.common.transferinstructions.CustomerData customer_data = 2;</code>
     * @param \Io\Token\Proto\Common\Transferinstructions\CustomerData $var
     * @return $this
     */
    public function setCustomerData($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Transferinstructions\CustomerData::class);
        $this->customer_data = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string bank_id = 3;</code>
     * @return string
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * Generated from protobuf field <code>string bank_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setBankId($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_id = $var;

        return $this;
    }

}

