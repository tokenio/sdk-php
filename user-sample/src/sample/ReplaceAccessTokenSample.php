<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Tokenio\Exception\IllegalArgumentException;
use Tokenio\User\AccessTokenBuilder;
use Tokenio\User\Member;
use Tokenio\User\TokenClient;

class ReplaceAccessTokenSample
{
    /**
     * @param $tokenClient TokenClient
     * @param $grantor Member
     * @param $granteeAlias Alias
     * @throws \Exception
     */
    public static function findAccessToken($tokenClient, $grantor, $granteeAlias)
    {
        $granteeMemberId = $tokenClient->getMemberId($granteeAlias);
        return $grantor->getActiveAccessToken($granteeMemberId);
    }

    /**
     * @param $grantor Member
     * @param $granteeAlias Alias
     * @param $oldToken Token
     * @return TokenOperationResult
     * @throws \Exception
     */
    public static function replaceAccessToken($grantor, $granteeAlias, $oldToken)
    {
        $accountId = $grantor->createTestBankAccount(1000.0, "EUR")->id();
        $accessToken = AccessTokenBuilder::fromPayload($oldToken->getPayload())->forAccount($accountId);
        $newToken = $grantor->replaceAccessToken($oldToken, $accessToken)->getToken();
        /* @var $status \Io\Token\Proto\Common\Token\TokenOperationResult */
        $status = $grantor->endorseToken($newToken, Level::STANDARD);
        return $status;
    }
}