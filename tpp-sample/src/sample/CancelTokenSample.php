<?php

namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use Tokenio\Tpp\Member;

/**
 * Cancels active tokens.
 */
class CancelTokenSample
{
    /**
     * Cancels an access token.
     *
     * @param Member $grantee grantee Token member
     * @param string $tokenId token ID to cancel
     * @return TokenOperationResult
     */
    public static function cancelAccessToken($grantee, $tokenId) {
        // Retrieve an access token to cancel.
        /** @var Token  $accessToken */
        $accessToken = $grantee->getToken($tokenId);

        // Cancel access token.
        return $grantee->cancelToken($accessToken);
    }

    /**
     * Cancels a transfer token.
     *
     * @param Member $payee payee Token member
     * @param string $tokenId token ID to cancel
     * @return TokenOperationResult
     */
    public static function cancelTransferToken($payee, $tokenId) {
        // Retrieve a transfer token to cancel.
        /** @var Token $transferToken */
        $transferToken = $payee->getToken($tokenId);

        // Cancel transfer token.
        return $payee->cancelToken($transferToken);
    }
}