<?php


namespace Io\Token\Samples;

use Io\Token\Proto\Common\Security\Key\Level;
use Tokenio\Member;

final class RedeemAccessTokenSample
{
    /**
     * Redeems access token to acquire access to the grantor's account balances.
     *
     * @param $grantee Member grantee Token member
     * @param $tokenId ID of the access token to redeem
     * @return balance of one of grantor's accounts
     */
    public static function redeemAccessToken($grantee, $tokenId)
    {
        $customerInitiated = true;

        $grantor = $grantee->forAccessToken($tokenId, $customerInitiated);
        $accounts = $grantor->getAccounts();

        $balance0 = $accounts[0]->getBalance(Level::STANDARD)->getCurrent();
        return $balance0;
    }
}