<?php


namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key\Level;
use Tokenio\User\Account;
use Tokenio\User\Member;

class GetBalanceSample
{
    /**
     * Get a member's balances
     * @param $member Member
     * @return array currency : total
     * @throws \Exception
     */
    public static function memberGetBalanceSample($member)
    {
        $sums = array();

        $accounts = $member->getAccounts();
        foreach($accounts as $account){
            /**@var Money**/
            $balance = $member->getCurrentBalance($account->id(), Level::STANDARD);

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
     * @throws \Exception
     */
    public static function accountGetBalanceSample($member)
    {
        $sums = array();

        $accounts = $member->getAccounts();
        foreach($accounts as $account){
            /**@var Money**/
            $balance = $account->getCurrentBalance(Level::STANDARD);

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
     * @throws \Exception
     */
    public static function memberGetBalanceListSample($member)
    {
        /**@var Account**/
        $accounts = $member->getAccounts();
        $accountIds = array();
        for($idx = 0; $idx < count($accounts); $idx++){
            $accountIds[$idx] = $accounts[$idx]->id();
        }

        return $member->getBalances($accountIds, Level::STANDARD);
    }
}