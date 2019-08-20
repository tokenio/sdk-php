<?php

namespace Test\Io\Token;
use PHPUnit\Framework\TestCase;
use Io\Token\Member;

class BankInfoTest extends TestCase
{

    /** @var \Io\Token\TokenClient */
    protected $tokenIO;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member = $this->tokenIO->createMember(TestUtil::generateAlias());
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }

    public function testGetBanks()
    {
        $this->assertNotEmpty($this->tokenIO->getBanks()->getBanks());
    }

    public function testGetBankInfo()
    {
        $bankId = $this->tokenIO->getBanks()->getBanks()->offsetGet(0)->getId();
        $this->assertNotNull($this->member->getBankInfo($bankId));
    }
}