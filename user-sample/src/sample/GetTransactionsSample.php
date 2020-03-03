<?php


namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transaction\TransactionStatus;
use Io\Token\Proto\Common\Transaction\TransactionType;
use Io\Token\Proto\Common\Transfer\Transfer;
use Tokenio\User\Member;

class GetTransactionsSample
{
    /**
     * Illustrate Member->getTransactions.
     *
     * @param $payer Member
     * @throws \Exception
     */
    public static function getTransactionsSample($payer)
    {
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->id();
        $transactions = $payer->getTransactions($accountId, null,10,Level::STANDARD)->getList();

        /**@var $transaction Transaction**/
        foreach($transactions as $transaction) {
            self::displayTransaction(
                $transaction->getAmount()->getCurrency(),
                $transaction->getAmount()->getValue(),
                $transaction->getType(),
                $transaction->getStatus());
        }
    }


    /**
     * @param $payer Member
     * @throws \Exception
     */
    public static function getTransactionsByDateSample($payer)
    {
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->id();
        $transactions = $payer->getTransactions($accountId, null,10,Level::STANDARD,"2020-02-15", "2020-02-15")->getList();

        /**@var $transaction Transaction**/
        foreach($transactions as $transaction) {
            self::displayTransaction(
                $transaction->getAmount()->getCurrency(),
                $transaction->getAmount()->getValue(),
                $transaction->getType(),
                $transaction->getStatus());
        }
    }
    /**
     * Illustrate Member.getTransaction
     *
     * @param $payer Member
     * @param $transfer Transfer
     * @return Transaction
     * @throws \Exception
     */
    public static function getTransactionSample($payer, $transfer)
    {
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->id();

        $transactionId = $transfer->getTransactionId();
        $transaction = $payer->getTransaction($accountId, $transactionId, Level::STANDARD);
        return $transaction;
    }

    /**
     * Illustrate Account.getTransactions
     * @param $payer Member
     * @throws \Exception
     */
    public static function accountGetTransactionsSample($payer)
    {
        $account = $payer->getAccounts()[0];
        $transactions = $account->getTransactions(null, 10, Level::STANDARD)->getList();

        foreach($transactions as $transaction){
            self::displayTransaction(
                $transaction->getAmount()->getCurrency(),
                $transaction->getAmount()->getValue(),
                $transaction->getType(),
                $transaction->getStatus());
        }
    }

    /**
     * Illustrate Account.getTransaction
     * @param $payer Member
     * @param $transfer Transfer
     * @return Transaction
     * @throws \Exception
     */
    public static function accountGetTransactionSample($payer, $transfer)
    {
        $account = $payer->getAccounts()[0];
        $txnId = $transfer->getTransactionId();
        return $account->getTransaction($txnId, Level::STANDARD);
    }


    private static function displayTransaction($currency, $value, $debitOrCredit, $status ){}
}