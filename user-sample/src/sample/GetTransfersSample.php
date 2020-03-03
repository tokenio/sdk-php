<?php


namespace Tokenio\Sample\User;


use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transfer\Transfer;
use Tokenio\User\Member;

class GetTransfersSample
{
    /**
     * Illustrate Member.getTransfers
     *
     * @param $payer Member
     * @throws \Exception
     */
    public static function getTransfersSample($payer){
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->id();

        $transfers = $payer->getTransfers(null, 10, null)->getList();

        /**@var $transfer Transfer**/
        foreach($transfers as $transfer){
            self::displayTransfer($transfer->getStatus(), $transfer->getPayload()->getDescription());
        }
    }

    /**
     * Illustrate Member.getTransferTokens
     *
     * @param $payer Member
     * @throws \Exception
     */
    public static function getTransferTokensSample($payer)
    {
        $tokens = $payer->getTransferTokens(null, 10)->getList();
        /** @var $token Token*/
        foreach($tokens as $token){
            $transferBody = $token->getPayload()->getTransfer();
            self::displayTransferToken($transferBody->getLifetimeAmount(), $transferBody->getCurrency());
        }
    }

    /**
     * Illustrate Member.getTransfer
     *
     * @param $payer Member
     * @param $transferId string
     * @return Transfer
     * @throws \Exception
     */
    public static function getTransferSample($payer, $transferId){
        return $payer->getTransfer($transferId);
    }

    private static function displayTransfer($status, $description){}

    private static function displayTransferToken($amount, $currency){}
}