<?php


namespace Io\Token\Sample\Tokenio;

use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Tokenio\Member;

class CancelTransferTokenSample
{
    /**
     * Cancels a transfer token
     *
     * @param $grantee Member
     * @param $tokenId string
     * @return TokenOperationResult
     */
    public static function cancelTransferToken($grantee, $tokenId)
    {
        /** @var Token **/
        $transferToken = $grantee->getToken($tokenId);
        return $grantee->cancelToken($transferToken);
    }
}