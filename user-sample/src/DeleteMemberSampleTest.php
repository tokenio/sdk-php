<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;
use Tokenio\Exception\StatusRuntimeException;

class DeleteMemberSampleTest extends TestCase
{
    public function testCreatePaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $member = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $this->assertEquals($member->getMemberId(), $tokenClient->getMember($member->getMemberId())->getMemberId());

        $member->deleteMember();
        $this->expectException(StatusRuntimeException::class);
        $tokenClient->getMember($member->getMemberId());
    }
}