<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Security\TokenCryptoEngine;

class MemberMethodsSampleTest extends TestCase
{
    public function testAliases()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        MemberMethodsSample::aliases($tokenClient, $member);

        $aliases = $member->aliases();
        $this->assertEquals(1, sizeof($aliases));
        $this->assertStringContainsString("alias4",$aliases[0]->getValue());
    }

    public function testKeys()
    {
        $tokenClient = TestUtil::createClient();
        $keyStore = new InMemoryKeyStore();
        $cryptoEngine = new TokenCryptoEngine("member-id", $keyStore);
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        MemberMethodsSample::keys($cryptoEngine, $member);
        $this->assertEquals(5, count($member->getKeys()));
    }

    public function testProfiles()
    {
        $tokenClient = TestUtil::createClient();
        $member = $tokenClient->createMember(TestUtil::randomAlias());
        $profile = MemberMethodsSample::profiles($member);

        $this->assertNotEmpty($profile->getDisplayNameFirst());
        $this->assertNotEmpty($profile->getDisplayNameLast());
    }
}