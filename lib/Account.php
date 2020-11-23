<?php

namespace Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;
use Tokenio\Rpc\Client;

class Account
{
    /**
     * @var Member
     */
    private $member;

    /**
     * @var \Io\Token\Proto\Common\Account\Account
     */
    private $account;

    /**
     * @var Client
     */
    private $client;

    /**
     * Creates the Account instance.
     *
     * @param Member $member the account owner
     * @param \Io\Token\Proto\Common\Account\Account $account the account information
     * @param Client $client the RPC client used to perform operations against the server
     */
    public function __construct($member, $account, $client)
    {
        $this->member = $member;
        $this->account = $account;
        $this->client = $client;
    }

    /**
     * Gets an account owner.
     *
     * @return Member account owner
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Gets an account ID.
     *
     * @return string account id
     */
    public function getId()
    {
        return $this->account->getId();
    }

    /**
     * Gets an account name.
     *
     * @return string account name
     */
    public function getName()
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
    public function getBankId()
    {
        return $this->account->getBankId();
    }

    /**
     * Looks up an account balance.
     *
     * @param int $level key level
     * @return Balance the account balance
     */
    public function getBalance($level)
    {
        return $this->client->getBalance($this->account->getId(), $level);
    }

    /**
     * Looks up an account current balance.
     *
     * @param int $level key level
     * @return Money the current balance
     */
    public function getCurrentBalance($level)
    {
        return $this->getBalance($level)->getCurrent();
    }
    /**
     * Looks up an account available balance.
     *
     * @param int $level key level
     * @return Money the available balance
     */
    public function getAvailableBalance($level)
    {
        return $this->getBalance($level)->getAvailable();
    }

    /**
     * Looks up transaction.
     *
     * @param string $transactionId transaction id
     * @param int $level key level
     * @return Transaction
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
     * @return PagedList
     */
    public function getTransactions($offset, $limit, $level)
    {
        return $this->client->getTransactions($this->account->getId(), $offset, $limit, $level);
    }

    /**
     * Resolves transfer destinations for the given account id.
     *
     * @param $accountId
     * @return RepeatedField transfer destinations
     */
    public function resolveTransferDestinations($accountId)
    {
        return $this->client->resolveTransferDestinations($accountId);
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
