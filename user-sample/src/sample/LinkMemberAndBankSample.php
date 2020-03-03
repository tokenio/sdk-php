<?php


namespace Tokenio\Sample\User;

use Tokenio\User\Account;
use Tokenio\User\Member;

class LinkMemberAndBankSample
{
    /**
     * @param $member Member
     * @return Account
     * @throws \Exception
     */
    public static function linkBankAccounts($member)
    {
        return $member->createTestBankAccount(1000.0, "EUR");
    }
}