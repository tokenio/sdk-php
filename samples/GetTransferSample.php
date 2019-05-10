<?php


namespace Io\Token\Samples;

use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transfer\Transfer;
use Tokenio\Member;

class GetTransferSample
{
    /**
     * Illustrate Member.getTransfers
     *
     * @param $payer Member
     */
    public static function getTransfers($payer){
        $accounts = $payer->getAccounts();
        $accountId = $accounts[0]->getId();

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
     */
    public static function getTransferTokens($payer)
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
     */
    public static function getTransfer($payer, $transferId){
        return $payer->getTransfer($transferId);
    }

    private static function displayTransfer($status, $description){}

    private static function displayTransferToken($amount, $currency){}
}