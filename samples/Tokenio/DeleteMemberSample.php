<?php


namespace Io\Token\Sample\Tokenio;

use Tokenio\Member;

class DeleteMemberSample
{
    /**
     * Deletes a member.
     *
     * @param $member Member
     */
    public static function deleteMember($member){
        $member->deleteMember();
    }
}