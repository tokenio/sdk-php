<?php

namespace Tokenio\Sample\Tpp;

use Tokenio\Tpp\Member;

/**
 * Deletes a member.
 */
class DeleteMemberSample
{
    /**
     * Deletes a member.
     *
     * @param Member $member member
     */
    public static function deleteMember($member) {
        $member->deleteMember();
    }
}