<?php


namespace Io\Token\Samples;

use Tokenio\Account;
use Tokenio\Member;

class NotifySample
{
    /**
     * Triggers a notification to step up the signature level when requesting balance information.
     *
     * @param $member Member
     * @param $accountIds Account[]
     * @return int status;
     */
    public static function triggerBalanceStepUpNotification($member, $accountIds){
        return $member->triggerBalanceStepUpNotification($accountIds);
    }
}