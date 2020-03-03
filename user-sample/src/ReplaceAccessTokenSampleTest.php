<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Tokenio\User\Member;

class ReplaceAccessTokenSampleTest extends TestCase
{

    public function testGetAccessTokens()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = $tokenClient->createMember(TestUtil::randomAlias());
        $accountId = $grantor->createTestBankAccount(1000, "EUR")->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $createdToken = CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $foundToken = ReplaceAccessTokenSample::findAccessToken($tokenClient, $grantor, $granteeAlias);
        $this->assertEquals($createdToken->getId(), $foundToken->getId());
    }

    public function testReplaceAccessToken()
    {
        $tokenClient = TestUtil::createClient();

        /* @var $grantor Member*/
        $grantor = $tokenClient->createMember(TestUtil::randomAlias());
        $accountId = $grantor->createTestBankAccount(1000, "EUR")->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $token1= CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $activeToken = ReplaceAccessTokenSample::findAccessToken($tokenClient, $grantor, $granteeAlias);
        ReplaceAccessTokenSample::replaceAccessToken($grantor, $granteeAlias, $activeToken);
        $this->assertNotEquals($activeToken->getId(), ReplaceAccessTokenSample::findAccessToken($tokenClient,
                                                                                                $grantor ,
                                                                                                $granteeAlias)->getId());
    }
}