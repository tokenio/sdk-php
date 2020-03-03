<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Tokenio\Tpp\Member;

class RedeemStandingOrderTokenSample
{
    /**
     * @param $payee Member
     * @param $tokenId string
     * @return StandingOrderSubmission
     * @throws \Exception
     */
    public static function redeemStandingOrderToken($payee, $tokenId)
    {
        $token = $payee->getToken($tokenId);

        $submission = $payee->redeemStandingOrderToken($token->getId());
        return $submission;
    }
}