<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key\Level;
use Tokenio\Tpp\Member;

;

class RedeemAccessTokenSample
{
    /**
     * @param $grantee Member
     * @param $tokenId string
     * @return Money
     * @throws \Exception
     */
    public static function redeemBalanceAccessToken($grantee, $tokenId)
    {
        $customerInitiated =true;
        $grantor= $grantee->forAccessToken($tokenId, $customerInitiated);
        $accounts = $grantor->getAccounts();

        $balance = $accounts[0]->getBalance(Level::STANDARD)->getCurrent();
        return $balance;
    }

    /**
     * @param $grantee Member
     * @param $tokenId string
     * @throws \Exception
     */
    public static function redeemTransactionsAccessToken($grantee, $tokenId)
    {
        $customerInitiated =true;
        $grantor= $grantee->forAccessToken($tokenId, $customerInitiated);
        $accounts = $grantor->getAccounts();
        $transactions = $accounts[0]->getTransactions(null, 10, Level::STANDARD);
        $transactionsByDate = $accounts[0]->getTransactions(null, 10, Level::STANDARD, "2019-01-15", "2022-01-15");
        $nextOffset = $transactions->getOffset();
        return $transactions->getList();
    }

    /**
     * @param $grantee Member
     * @param $tokenId string
     * @return mixed
     * @throws \Exception
     */
    public static function redeemStandingOrdersAccessToken($grantee, $tokenId)
    {
        $customerInitiated =true;
        $grantor= $grantee->forAccessToken($tokenId, $customerInitiated);
        $accounts = $grantor->getAccounts();

        $transactions = $accounts[0]->getTransactions(null, 10, Level::STANDARD);
        $standingOrders = $accounts[0]->getStandingOrders(null, 5, Level::STANDARD);
        $nextOffset = $standingOrders->getOffset();
        return $standingOrders->getList();
    }
}

