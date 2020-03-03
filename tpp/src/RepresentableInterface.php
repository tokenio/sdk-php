<?php

namespace Tokenio\Tpp;

use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\AccessBody\Resource\TransferDestinations;
use Io\Token\Proto\Common\Transaction\Balance;
use Io\Token\Proto\Common\Transaction\StandingOrder;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use PhpParser\Node\Expr\List_;
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
     * @param $keyLevel Key\Level
     * @param $startDate string
     * @param $endDate string
     * @return PagedList
     */
    function getTransactions(
        $accountId,
        $offset = null,
        $limit,
        $keyLevel,
        $startDate = null,
        $endDate = null);

    /**
     * @param $accountId string
     * @param $standingOrderId string
     * @param $keyLevel Key\Level
     * @return StandingOrder record
     */
    function getStandingOrder($accountId, $standingOrderId, $keyLevel);

    /**
     * @param $accountId string
     * @param $offset string
     * @param $limit int
     * @param $keyLevel Key\Level
     * @return PagedList of standing order records.
     */
    function getStandingOrders($accountId, $offset = null, $limit, $keyLevel);

    /**
     * @var $accountId string
     * @return TransferDestination[]
     */
    function resolveTransferDestinations($accountId);

    /**
     * @var $accountId string
     * @var $amount double
     * @var $currency string
     * @return boolean
     */
    function confirmFunds($accountId, $amount, $currency);
}
