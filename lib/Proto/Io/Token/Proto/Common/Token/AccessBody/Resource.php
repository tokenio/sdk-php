<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\AccessBody;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.token.AccessBody.Resource</code>
 */
class Resource extends \Google\Protobuf\Internal\Message
{
    protected $resource;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\Account $account
     *           access to account data
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountTransactions $transactions
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountStandingOrders $standing_orders
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountBalance $balance
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\TransferDestinations $transfer_destinations
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\FundsConfirmation $funds_confirmation
     *           other permissions
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\Address $address
     *           deprecated
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAddresses $all_addresses
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccounts $all_accounts
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountTransactions $all_transactions
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountBalances $all_balances
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinations $all_transfer_destinations
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountsAtBank $all_accounts_at_bank
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransactionsAtBank $all_transactions_at_bank
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllBalancesAtBank $all_balances_at_bank
     *     @type \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinationsAtBank $all_transfer_destinations_at_bank
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * access to account data
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.Account account = 6;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\Account
     */
    public function getAccount()
    {
        return $this->readOneof(6);
    }

    /**
     * access to account data
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.Account account = 6;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\Account $var
     * @return $this
     */
    public function setAccount($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_Account::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountTransactions transactions = 7;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountTransactions
     */
    public function getTransactions()
    {
        return $this->readOneof(7);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountTransactions transactions = 7;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountTransactions $var
     * @return $this
     */
    public function setTransactions($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AccountTransactions::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountStandingOrders standing_orders = 16;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountStandingOrders
     */
    public function getStandingOrders()
    {
        return $this->readOneof(16);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountStandingOrders standing_orders = 16;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountStandingOrders $var
     * @return $this
     */
    public function setStandingOrders($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AccountStandingOrders::class);
        $this->writeOneof(16, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountBalance balance = 8;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountBalance
     */
    public function getBalance()
    {
        return $this->readOneof(8);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AccountBalance balance = 8;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AccountBalance $var
     * @return $this
     */
    public function setBalance($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AccountBalance::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.TransferDestinations transfer_destinations = 12;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\TransferDestinations
     */
    public function getTransferDestinations()
    {
        return $this->readOneof(12);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.TransferDestinations transfer_destinations = 12;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\TransferDestinations $var
     * @return $this
     */
    public function setTransferDestinations($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_TransferDestinations::class);
        $this->writeOneof(12, $var);

        return $this;
    }

    /**
     * other permissions
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.FundsConfirmation funds_confirmation = 15;</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\FundsConfirmation
     */
    public function getFundsConfirmation()
    {
        return $this->readOneof(15);
    }

    /**
     * other permissions
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.FundsConfirmation funds_confirmation = 15;</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\FundsConfirmation $var
     * @return $this
     */
    public function setFundsConfirmation($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_FundsConfirmation::class);
        $this->writeOneof(15, $var);

        return $this;
    }

    /**
     * deprecated
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.Address address = 5 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\Address
     */
    public function getAddress()
    {
        return $this->readOneof(5);
    }

    /**
     * deprecated
     *
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.Address address = 5 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\Address $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_Address::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAddresses all_addresses = 1 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAddresses
     */
    public function getAllAddresses()
    {
        return $this->readOneof(1);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAddresses all_addresses = 1 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAddresses $var
     * @return $this
     */
    public function setAllAddresses($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllAddresses::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccounts all_accounts = 2 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccounts
     */
    public function getAllAccounts()
    {
        return $this->readOneof(2);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccounts all_accounts = 2 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccounts $var
     * @return $this
     */
    public function setAllAccounts($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllAccounts::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountTransactions all_transactions = 3 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountTransactions
     */
    public function getAllTransactions()
    {
        return $this->readOneof(3);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountTransactions all_transactions = 3 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountTransactions $var
     * @return $this
     */
    public function setAllTransactions($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllAccountTransactions::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountBalances all_balances = 4 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountBalances
     */
    public function getAllBalances()
    {
        return $this->readOneof(4);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountBalances all_balances = 4 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountBalances $var
     * @return $this
     */
    public function setAllBalances($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllAccountBalances::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransferDestinations all_transfer_destinations = 13 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinations
     */
    public function getAllTransferDestinations()
    {
        return $this->readOneof(13);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransferDestinations all_transfer_destinations = 13 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinations $var
     * @return $this
     */
    public function setAllTransferDestinations($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllTransferDestinations::class);
        $this->writeOneof(13, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountsAtBank all_accounts_at_bank = 9 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountsAtBank
     */
    public function getAllAccountsAtBank()
    {
        return $this->readOneof(9);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllAccountsAtBank all_accounts_at_bank = 9 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllAccountsAtBank $var
     * @return $this
     */
    public function setAllAccountsAtBank($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllAccountsAtBank::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransactionsAtBank all_transactions_at_bank = 10 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransactionsAtBank
     */
    public function getAllTransactionsAtBank()
    {
        return $this->readOneof(10);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransactionsAtBank all_transactions_at_bank = 10 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransactionsAtBank $var
     * @return $this
     */
    public function setAllTransactionsAtBank($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllTransactionsAtBank::class);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllBalancesAtBank all_balances_at_bank = 11 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllBalancesAtBank
     */
    public function getAllBalancesAtBank()
    {
        return $this->readOneof(11);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllBalancesAtBank all_balances_at_bank = 11 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllBalancesAtBank $var
     * @return $this
     */
    public function setAllBalancesAtBank($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllBalancesAtBank::class);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransferDestinationsAtBank all_transfer_destinations_at_bank = 14 [deprecated = true];</code>
     * @return \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinationsAtBank
     */
    public function getAllTransferDestinationsAtBank()
    {
        return $this->readOneof(14);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.AccessBody.Resource.AllTransferDestinationsAtBank all_transfer_destinations_at_bank = 14 [deprecated = true];</code>
     * @param \Io\Token\Proto\Common\Token\AccessBody\Resource\AllTransferDestinationsAtBank $var
     * @return $this
     */
    public function setAllTransferDestinationsAtBank($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\AccessBody_Resource_AllTransferDestinationsAtBank::class);
        $this->writeOneof(14, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->whichOneof("resource");
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Resource::class, \Io\Token\Proto\Common\Token\AccessBody_Resource::class);

