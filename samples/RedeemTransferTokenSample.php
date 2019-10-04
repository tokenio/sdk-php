<?php


namespace Io\Token\Samples;

use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Tokenio\Member;
use Tokenio\Util\Strings;

final class RedeemTransferTokenSample
{
    /**
     * Redeems a transfer token to transfer money from payer bank account to payee bank account.
     *
     * @param $payee Member payee Token member
     * @param $accountId string account id of the payee
     * @param $tokenId string ID of the token to redeem
     * @return Transfer
     */
    public static function redeemTransferToken($payee, $accountId, $tokenId)
    {
        $cartId =  Strings::generateNonce();

        $transferToken = $payee->getToken($tokenId);
        $destination = new TransferDestination\Token();
        $destination->setMemberId($payee->getMemberId());
        $destination->setAccountId($accountId);

        return $payee->redeemToken($transferToken, $destination, $cartId);
    }
}