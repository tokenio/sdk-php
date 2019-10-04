<?php


namespace Io\Token\Samples;

use Io\Token\Proto\Common\Account\BankAccount;
use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Io\Token\Proto\Common\Transfer\Transfer;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use Io\Token\Proto\Common\Transferinstructions\TransferEndpoint;
use Tokenio\Member;
use Tokenio\Util\Strings;

final class RedeemStandingOrderTokenSample
{
    /**
     * Redeems a standing order token to make a series of transfer from payer bank account
     * to payee bank account.
     *
     * @param $payee Member payee Token member
     * @param $tokenId string ID of the token to redeem
     * @return StandingOrderSubmission submission record
     */
    public static function redeemStandingOrderToken($payee, $tokenId)
    {
        return $payee->redeemStandingOrderToken($tokenId);
    }
}
