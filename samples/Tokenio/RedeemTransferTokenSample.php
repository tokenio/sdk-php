<?php


namespace Io\Token\Sample\Tokenio;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Tokenio\Member;
use Tokenio\Util\Strings;

final class RedeemTransferTokenSample
{
    /**
     * Redeems a transfer token to transfer money from payer bank account to payee bank account.
     *
     * @param $payee Member payee Token member
     * @param $accountid string account id of the payee
     * @param $tokenId ID of the token to redeem
     * @return \Io\Token\Proto\Common\Transfer\Transfer
     */
    public static function redeemTransferToken($payee, $accountid, $tokenId)
    {
        $cartId =  Strings::generateNonce();

        $transferToken = $payee->getToken($tokenId);
        $token = new BankAccount\Token();
        $token->setMemberId($payee->getMemberId());
        $token->setAccountId($accountid);
        $account = new BankAccount();
        $account->setToken($token);

        $tokenDestination = new TransferEndpoint();
        $tokenDestination->setAccount($account);

        return $payee->redeemToken($transferToken, $tokenDestination, $cartId);
    }
}