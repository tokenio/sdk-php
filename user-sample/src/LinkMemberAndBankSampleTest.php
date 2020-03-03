<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;
use Tokenio\Util\Strings;

class LinkMemberAndBankSampleTest extends TestCase
{
    public function testLinkMemberAndBankTest()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());

        LinkMemberAndBankSample::linkBankAccounts($member);
        $this->assertFalse(empty($member->getAccounts()));
    }
}