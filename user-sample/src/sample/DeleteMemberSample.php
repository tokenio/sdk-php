<?php

namespace Tokenio\Sample\User;

use Tokenio\User\Member;

class DeleteMemberSample
{
    /**
     * @param $member Member
     * @throws \Exception
     */
    public static function deleteMember($member)
    {
        $member->deleteMember();
    }
}