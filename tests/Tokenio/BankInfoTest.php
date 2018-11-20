<?php

namespace Test\Tokenio;

class BankInfoTest extends TokenBaseTest
{

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