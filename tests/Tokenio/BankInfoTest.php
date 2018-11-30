<?php

namespace Test\Tokenio;
require_once 'TokenBaseTest.php';

class BankInfoTest extends TokenBaseTest
{

    protected function setUp()
    {
        parent::setUp();
        $this->member = $this->tokenIO->createMember(self::generateAlias());
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