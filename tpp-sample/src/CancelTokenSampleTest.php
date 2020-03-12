<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\TokenOperationResult;
use PHPUnit\Framework\TestCase;
use Tokenio\Sample\User\CreateAndEndorseAccessTokenSample;
use Tokenio\Sample\User\CreateTransferTokenSample;

class CancelTokenSampleTest extends TestCase
{
    public function testCancelAccessTokenByGrantee()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = TestUtil::createUserMember();
        $accountId = $grantor->getAccounts()[0]->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $token = CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $result = CancelTokenSample::cancelAccessToken($grantee, $token->getId());
        $this->assertEquals(TokenOperationResult\Status::SUCCESS, $result->getStatus());
    }

    public function testCancelTransferTokenByGrantee()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = TestUtil::createUserMember();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);
        $token = CreateTransferTokenSample::createTransferToken($grantor, $granteeAlias, Level::LOW);
        $result = CancelTokenSample::cancelTransferToken($grantee, $token->getId());
        $this->assertEquals(TokenOperationResult\Status::SUCCESS, $result->getStatus());
    }
}