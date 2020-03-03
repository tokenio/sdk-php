<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;

class GetBalanceSampleTest extends TestCase
{
    public function testMemberGetBalanceSample()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        $member->createTestBankAccount(1000.0, "EUR");
        $sums = GetBalanceSample::memberGetBalanceSample($member);
        $this->assertEquals(1000.0, $sums["EUR"]);
    }

    public function testAccountGetBalanceSample()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        $member->createTestBankAccount(1000.0, "EUR");
        $sums = GetBalanceSample::accountGetBalanceSample($member);
        $this->assertEquals(1000.0, $sums["EUR"]);
    }

    public function testMemberGetBalancesSample()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        $member->createTestBankAccount(1000.0, "EUR");
        $member->createTestBankAccount(500.0, "EUR");

        $balances = GetBalanceSample::memberGetBalanceListSample($member);
        $this->assertEquals(2, sizeof($balances));
    }
}