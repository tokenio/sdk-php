<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\User\Member;
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

        $transferDestination = new TransferDestination\Token();
        $transferDestination->setMemberId($payee->getMemberId())->setAccountId($accountId);

        $tokenDestination = new TransferDestination();
        $tokenDestination->setToken($transferDestination);

        $transfer = $payee->redeemToken($transferToken,null, null, null, $tokenDestination, $cartId);
        return $transfer;
    }
}