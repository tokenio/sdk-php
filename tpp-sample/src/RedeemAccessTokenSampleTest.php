<?php


namespace Tokenio\Sample\Tpp;

use Exception;
use Io\Token\Proto\Common\Money\Money;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\Token;
use PHPUnit\Framework\TestCase;
use Tokenio\Sample\User\CreateAndEndorseAccessTokenSample;
use Tokenio\Sample\User\CreateStandingOrderTokenSample;
use Tokenio\Sample\User\CreateTransferTokenSample;
use Tokenio\Tpp\TokenClient;
use Tokenio\User\Member;


class RedeemAccessTokenSampleTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRedeemBalanceAccessToken()
    {
        /** @var TokenClient $tokenClient */
        $tokenClient = TestUtil::createClient();

        /** @var Member $grantor */
        $grantor = TestUtil::createUserMember();
        $accountId = $grantor->getAccounts()[0]->id();
        $granteeAlias = TestUtil::randomAlias();

        /** @var \Tokenio\Tpp\Member $grantee */
        $grantee = $tokenClient->createMember($granteeAlias);

        /** @var Token $token */
        $token = CreateAndEndorseAccessTokenSample::createBalanceAccessToken($grantor, $accountId, $granteeAlias);
        $balance = RedeemAccessTokenSample::redeemBalanceAccessToken($grantee, $token->getId());
        $this->assertGreaterThan(10, intval($balance->getValue()));
    }

    public function testRedeemTransactionsAccessToken()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = TestUtil::createUserMember();

        $accountId = $grantor->getAccounts()[0]->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);

        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = $payee->createTestBankAccount(1000, "EUR");

        for($i = 0; $i< 5; $i++)
        {
            $token = CreateTransferTokenSample::createTransferToken($grantor, $payeeAlias, Level::STANDARD);
            RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        }

        $token = CreateAndEndorseAccessTokenSample::createTransactionsAccessToken($grantor, $accountId, $granteeAlias);
        $transactions = RedeemAccessTokenSample::redeemTransactionsAccessToken($grantee, $token->getId());
        $this->assertEquals(5, sizeof($transactions));
    }

    public function testRedeemStandingOrdersAccessToken()
    {
        $tokenClient = TestUtil::createClient();
        $grantor = TestUtil::createUserMember();

        $accountId = $grantor->getAccounts()[0]->id();
        $granteeAlias = TestUtil::randomAlias();
        $grantee = $tokenClient->createMember($granteeAlias);

        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);

        for($i = 0; $i< 10; $i++)
        {
            $token = CreateStandingOrderTokenSample::createStandingOrderToken($grantor, $payeeAlias, Level::STANDARD);
            RedeemStandingOrderTokenSample::redeemStandingOrderToken($payee, $token->getId());
        }

        $newToken = CreateAndEndorseAccessTokenSample::createStandingOrdersAccessToken($grantor, $accountId, $granteeAlias);
        $standingOrders = RedeemAccessTokenSample::redeemStandingOrdersAccessToken($grantee, $newToken->getId());
        $this->assertEquals(5, sizeof($standingOrders));
    }
}