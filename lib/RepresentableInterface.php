<?php

namespace Io\Token;

use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;

/**
 * Represents the part of a token member that can be accessed through an access token.
 */
interface RepresentableInterface
{
    /**
     * Links a funding bank account to Token and returns it to the caller.
     *
     * @return Account[]
     */
    public function getAccounts();

    /**
     * Looks up a funding bank account linked to Token.
     *
     * @param string $accountId account id
     * @return Account
     */
    public function getAccount($accountId);

    /**
     * Looks up account balance.
     *
     * @param string $accountId account id
     * @param int $keyLevel key level
     * @return Balance
     */
    public function getBalance($accountId, $keyLevel);

    /**
     * Looks up transactions for a given account.
     *
     * @param string $accountId the account id
     * @param string $offset optional offset to start at
     * @param int $limit max number of records to return
     * @param int $keyLevel key level
     * @return PagedList paged list of transaction records
     */
    public function getTransactions($accountId, $offset, $limit, $keyLevel);

    /**
     * Looks up an existing transaction for a given account.
     *
     * @param string $accountId account id
     * @param string $transactionId ID of the transaction
     * @param int $keyLevel key level
     * @return Transaction
     */
    public function getTransaction($accountId, $transactionId, $keyLevel);
}
