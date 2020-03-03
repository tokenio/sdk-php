<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Tokenio\Sample\User\CreateStandingOrderTokenSample;

class RedeemStandingOrderTokenSampleTest extends TestCase
{
    public function testRedeemStandingOrderToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createUserMember();
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = $payee->createTestBankAccount(1000, "EUR");
        $token = CreateStandingOrderTokenSample::createStandingOrderToken($payer, $payeeAlias, Level::STANDARD);
        $submission = RedeemStandingOrderTokenSample::redeemStandingOrderToken($payee, $token->getId());
        $this->assertNotNull($submission);
    }
}