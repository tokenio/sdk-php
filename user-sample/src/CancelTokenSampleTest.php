<?php

namespace Tokenio\Sample\User;



use Io\Token\Proto\Common\Token\TokenOperationResult;
use PHPUnit\Framework\TestCase;

class CancelTokenSampleTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCancelAccessTokenByGrantor()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = $tokenClient->createMember(TestUtil::randomAlias());
        $accountId = $grantor->createTestBankAccount(1000.0, "EUR")->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $token = CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $result = CancelTokenSample::cancelAccessToken($grantor, $token->getId());
        $this->assertEquals(TokenOperationResult\Status::SUCCESS, $result->getStatus());
    }
}