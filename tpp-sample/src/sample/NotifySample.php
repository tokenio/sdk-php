<?php


namespace Tokenio\Sample\Tpp;

use Tokenio\Tpp\Member;

class NotifySample
{
    /**
     * Triggers a notification to step up the signature level when requesting balance information.
     *
     * @param $member Member
     * @param $accountIds string[]
     * @return int status;
     * @throws \Exception
     */
    public static function triggerBalanceStepUpNotification($member, $accountIds){
        return $member->triggerBalanceStepUpNotification($accountIds);
    }
}