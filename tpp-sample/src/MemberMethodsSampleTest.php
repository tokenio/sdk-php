<?php


namespace Tokenio\Sample\Tpp;

use PHPUnit\Framework\TestCase;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Tpp\Member;

class MemberMethodsSampleTest extends TestCase
{
    /** @var \Tokenio\Tpp\TokenClient */
    private $tokenClient;

    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenClient = TestUtil::createClient();
        $this->member = $this->tokenClient->createMember(TestUtil::randomAlias());
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testKeys()
    {
        $keyStore = new InMemoryKeyStore();
        $cryptoEngine = new TokenCryptoEngine("member-id", $keyStore);

        MemberMethodsSample::keys($cryptoEngine, $this->member);
        //TODO: remove this
        $this->assertTrue(true);
    }


    public function testProfiles()
    {
        $profile = MemberMethodsSample::profiles($this->member);

        $this->assertNotEmpty($profile->getDisplayNameLast());
        $this->assertNotEmpty($profile->getDisplayNameLast());
    }
}