<?php


namespace Io\Token\Samples;

use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Tokenio\Member;

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
