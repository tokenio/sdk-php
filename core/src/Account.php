<?php

namespace Tokenio;

use Io\Token\Proto\Common\Account\AccountDetails;
use Io\Token\Proto\Common\Account\AccountFeatures;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;
use Tokenio\Rpc\Client;

class Account
{
    /**
     * @var Member
     */
    protected $member;

    /**
     * @var \Io\Token\Proto\Common\Account\Account
     */
    protected $account;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Creates the Account instance.
     *
     * @param Member $member the account owner
     * @param Account $account
     * @param \Io\Token\Proto\Common\Account\Account $accountProtos the account information
     * @param Client $client the RPC client used to perform operations against the server
     */
    public function __construct($member, $client, $account = null, $accountProtos = null)
    {
        if($accountProtos != null){
            $this->account = $accountProtos;
            $this->member = $member;
            $this->client = $client;
        } else{
            $this->account = $account->account;
            $this->member = $account->member;
            $this->client = $account->client;
        }
    }

    /**
     * Gets an account owner.
     *
     * @return Member account owner
     */
    public function member()
    {
        return $this->member;
    }

    /**
     * Gets an account ID.
     *
     * @return string account id
     */
    public function id()
    {
        return $this->account->getId();
    }

    /**
     * Gets an account name.
     *
     * @return string account name
     */
    public function name()
    {
        return $this->account->getName();
    }

    /**
     * Looks up if this account is locked.
     *
     * @return bool true if this account is locked; false otherwise.
     */
    public function isLocked()
    {
        return $this->account->getIsLocked();
    }

    /**
     * Gets the bank ID.
     *
     * @return string the bank ID
     */
    public function bankId()
    {
        return $this->account->getBankId();
    }

    /**
     * Gets the account details.
     *
     * @return AccountDetails
     */
    public function accountDetails() {
        return $this->account->getAccountDetails();
    }

    /**
     * Gets the account features.
     *
     * @return AccountFeatures features
     */
    public function accountFeatures() {
        return $this->account->getAccountFeatures();
    }

    /**
     * Looks up an account balance.
     *
     * @param int $level key level
     * @return Balance the account balance
     * @throws Exception\RequestException
     * @throws Exception\StepUpRequiredException
     * @throws \Exception
     */
    public function getBalance($level)
    {
        return $this->client->getBalance($this->account->getId(), $level);
    }

    /**
     * Looks up transaction.
     *
     * @param string $transactionId transaction id
     * @param int $level key level
     * @return Transaction
     * @throws Exception\RequestException
     * @throws Exception\StepUpRequiredException
     */
    public function getTransaction($transactionId, $level)
    {
        return $this->client->getTransaction($this->account->getId(), $transactionId, $level);
    }

    /**
     * Looks up transactions.
     *
     * @param string $offset nullable offset
     * @param int $limit
     * @param int $level key level
     * @param string $startDate inclusive lower bound of transaction booking date
     * @param string $endDate inclusive upper bound of transaction booking date
     * @return PagedList
     * @throws Exception\RequestException
     * @throws Exception\StepUpRequiredException
     */
    public function getTransactions($offset, $limit, $level, $startDate = null, $endDate = null)
    {
        return $this->client->getTransactions($this->account->getId(), $offset, $limit, $level, $startDate, $endDate);
    }

    /**
     * Fetches the original {@link AccountProtos.Account} object.
     *
     * @return \Io\Token\Proto\Common\Account\Account the account.
     */
    public function toProto()
    {
        return $this->account;
    }
}
