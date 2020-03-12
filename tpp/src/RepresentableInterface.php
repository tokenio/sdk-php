<?php

namespace Tokenio\Tpp;

use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\PagedList;

/**
 * Represents the part of a token member that can be accessed through an access token.
 */
interface RepresentableInterface
{
    /**
     * Looks up funding bank accounts linked to Token.
     *
     * @return Account[] accounts
     */
    function getAccounts();

    /**
     * Looks up funding bank account linked to Token.
     *
     * @var $accountId string
     * @return Account account
     */
    function getAccount($accountId);

    /**
     * Looks up account balance.
     *
     * @param $keyLevel Key\Level key level.
     * @param $accountId String
     * @return Balance
     */
    function getBalance($accountId, $keyLevel);

    /**
     * Looks up balances for a list of accounts.
     *
     * @param $accountIds Account[] list of account ids
     * @param $keyLevel Key\Level level
     * @return array of balances
     */
    function getBalances($accountIds, $keyLevel);

    /**
     * Looks up an existing transaction for a given account.
     *
     * @param $accountId String
     * @param $transactionId String
     * @param $keyLevel Key\Level
     * @return Transaction
     */
    function getTransaction($accountId, $transactionId, $keyLevel);

    /**
     * Looks up an transactions for a given account.
     *
     * @param $accountId string
     * @param $offset string
     * @param $limit int
     * @param $keyLevel int
     * @param $startDate string
     * @param $endDate string
     * @return PagedList
     */
    function getTransactions(
        $accountId,
        $offset,
        $limit,
        $keyLevel,
        $startDate = null,
        $endDate = null);

    /**
     * @var $accountId string
     * @return TransferDestination[]
     */
    function resolveTransferDestinations($accountId);

}
