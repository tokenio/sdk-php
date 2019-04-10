<?php


namespace Sample\Tokenio;


use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Transaction\Balance;
use Tokenio\Account;
use Tokenio\Member;

class GetBalanceSample
{

    /**
     * Get a member's balances
     *
     * @param $member Member
     * @return array currency : total
     */
    public static function memberGetBalance($member)
    {
        $sums = array();

        $accounts = $member->getAccounts();
        foreach($accounts as $account){
            /**@var Money**/
            $balance = $member->getBalance($account->getId(), Level::STANDARD)
                              ->getCurrent();

            $sums[$balance->getCurrency()]
                = isset($sums[$balance->getCurrency()])
                ? $sums[$balance->getCurrency()] + doubleval($balance->getValue())
                : doubleval($balance->getValue());
        }

        return $sums;
    }

    /**
     * Get a member's balances
     *
     * @param $member Member
     * @return array currency : total
     */
    public static function accountGetBalance($member)
    {
        $sums = array();

        $accounts = $member->getAccounts();
        foreach($accounts as $account){
            /**@var Money**/
            $balance = $account->getBalance(Level::STANDARD)
                               ->getCurrent();

            $sums[$balance->getCurrency()]
                = isset($sums[$balance->getCurrency()])
                ? $sums[$balance->getCurrency()] + doubleval($balance->getValue())
                : doubleval($balance->getValue());
        }

        return $sums;
    }

    /**
     * Get a member's list of Balances.
     *
     * @param $member Member
     * @return array Balance
     */
    public static function memberGetBalanceList($member)
    {
        /**@var Account**/
        $accounts = $member->getAccounts();
        $accountIds = array();
        for($idx = 0; $idx < count($accounts); $idx++){
            $accountIds[idx] = $accounts[idx]->getId();
        }

        return $member->getBalances($accountIds, Level::STANDARD);
    }
}