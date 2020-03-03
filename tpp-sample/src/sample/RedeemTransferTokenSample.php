<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\Tpp\Member;
use Tokenio\Util\Strings;

class RedeemTransferTokenSample
{
    /**
     * @param $payee Member
     * @param $accountId string
     * @param $tokenId string
     * @return Transfer
     * @throws \Exception
     */
    public static function redeemTransferToken($payee, $accountId, $tokenId)
    {
        $cartId = Strings::generateNonce();
        $transferToken = $payee->getToken($tokenId);

        $token = new TransferDestination\Token();
        $token->setMemberId($payee->getMemberId())->setAccountId($accountId);

        $tokenDestination = new TransferDestination();
        $tokenDestination->setToken($token);

        $transfer = $payee->redeemToken($transferToken,null, null, null, $tokenDestination, $cartId);
        return $transfer;
    }
}