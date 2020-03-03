<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Submission\StandingOrderSubmission;
use Io\Token\Proto\Common\Token\Token;
use Tokenio\User\Member;

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
        /** @var Token $token */
        $token = $payee->getToken($tokenId);

        $submisssion = $payee->redeemStandingOrderToken($token->getId());
        return $submisssion;
    }
}