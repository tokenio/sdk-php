<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;

class CreateAndEndorseAccessTokenSampleTest extends TestCase
{
    public function testCreateAccessToken()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = $tokenClient->createMember(TestUtil::randomAlias());
        $accountId = $grantor->createTestBankAccount(1000, "EUR")->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $token = CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $this->assertNotNull($token);
    }
}