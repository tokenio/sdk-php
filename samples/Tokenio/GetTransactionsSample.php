<?php


namespace Io\Token\Sample\Tokenio;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Transaction\Transaction;
use Io\Token\Proto\Common\Transfer\Transfer;
use Tokenio\Member;

class GetTransactionsSample
{
    /**
     * Illustrate Member->getTransactions.
     *
     * @param $payer Member
     */
    public static function getTransactions($payer)
    {
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->getId();
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
     * Illustrate Member.getTransaction
     *
     * @param $payer Member
     * @param $transfer Transfer
     * @return Transaction
     */
    public static function getTransaction($payer, $transfer)
    {
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->getId();

        $transactionId = $transfer->getTransactionId();
        $transaction = $payer->getTransaction($accountId, $transactionId, Level::STANDARD);
        return $transaction;
    }

    /**
     * Illustrate Account.getTransactions
     *
     * @param $payer Member
     */
    public static function accountGetTransactions($payer)
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
     *
     * @param $payer Member
     * @param $transfer Transfer
     * @return Transaction
     */
    public static function accountGetTransaction($payer, $transfer)
    {
        $account = $payer->getAccounts()[0];
        $txnId = $transfer->getTransactionId();
        return $account->getTransaction($txnId, Level::STANDARD);
    }

    private static function displayTransaction($currency, $amount, $type, $status ){}
}