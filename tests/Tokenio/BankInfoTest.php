<?php

namespace Test\Tokenio;
use PHPUnit\Framework\TestCase;
use Tokenio\Member;
use Tokenio\Util\TestUtil;

class BankInfoTest extends TestCase
{

    /** @var \Tokenio\TokenIO */
    protected $tokenIO;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member = $this->tokenIO->createMember(TestUtil::generateAlias());
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