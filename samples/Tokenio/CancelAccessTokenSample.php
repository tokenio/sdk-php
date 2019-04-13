<?php


namespace Io\Token\Sample\Tokenio;

use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Tokenio\Member;

class CancelAccessTokenSample
{
    /**
     * Cancels the access token
     *
     * @param $grantee Member
     * @param $tokenId string
     * @return TokenOperationResult
     */
    public static function cancelAccessToken($grantee, $tokenId){
        /** @var Token **/
        $accessToken = $grantee->getToken($tokenId);
        return $grantee->cancelToken($accessToken);
    }
}
