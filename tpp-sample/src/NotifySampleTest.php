<?php


namespace Tokenio\Sample\Tpp;

use PHPUnit\Framework\TestCase;

class NotifySampleTest extends TestCase
{
    public function testTriggerBalanceStepUpNotificationTest()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());

        $status = $member->triggerBalanceStepUpNotification(array("123","456"));
        $this->assertNotEmpty($status);
    }
}