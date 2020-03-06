<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\Token;
use Tokenio\User\AccessTokenBuilder;
use Tokenio\User\Member;

class CreateAndEndorseAccessTokenSample
{
    /**
     * @param $grantor Member
     * @param $accountId string
     * @param $granteeAlias Alias
     * @return Token
     * @throws \Exception
     */
    public static function createBalanceAccessToken($grantor, $accountId, $granteeAlias)
    {
        $newAccessToken = AccessTokenBuilder::create($granteeAlias);
        $newAccessToken->forAccount($accountId)->forAccountBalances($accountId);
        $accessToken = $grantor->createAccessToken($newAccessToken);
        return $grantor->endorseToken($accessToken, Key\Level::STANDARD)->getToken();
    }

    /**
     * @param $grantor Member
     * @param $accountId string
     * @param $granteeAlias Alias
     * @return Token
     * @throws \Exception
     */
    public static function createTransactionsAccessToken($grantor, $accountId, $granteeAlias)
    {

        $newAccessToken = AccessTokenBuilder::create($granteeAlias)->forAccount($accountId)->forAccountTransactions($accountId);
        /* @var $newAccessToken AccessTokenBuilder*/
        $accessToken = $grantor->createAccessToken($newAccessToken);
        return $grantor->endorseToken($accessToken, Key\Level::STANDARD)->getToken();
    }


}