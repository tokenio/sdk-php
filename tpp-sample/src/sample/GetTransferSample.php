<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Transaction\TransactionStatus;
use Io\Token\Proto\Common\Transfer\Transfer;
use Tokenio\Tpp\Member;


class GetTransferSample
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
            self::displayTransferToken($transferBody->getCurrency(), $transferBody->getLifetimeAmount());
        }
    }

    /**
     * Illustrate Member.getTransfer
     *
     * @param $payer Member payer Token member
     * @param $transferId string id of a transfer
     * @return Transfer
     * @throws \Exception
     */
    public static function getTransferSample($payer, $transferId){
        return $payer->getTransfer($transferId);
    }

    /**
     * @param $status int
     * @param $description string
     */
    private static function displayTransfer($status, $description){}

    /**
     * @param $currency string
     * @param $value string
     */
    private static function displayTransferToken($currency, $value){}
}