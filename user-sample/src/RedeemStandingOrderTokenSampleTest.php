<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;

class RedeemStandingOrderTokenSampleTest extends TestCase
{
    public function testRedeemStandingOrderToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = $payee->createTestBankAccount(1000, "EUR");
        $token = CreateStandingOrderTokenSample::createStandingOrderToken($payer, $payeeAlias, Level::STANDARD);
        $submission = RedeemStandingOrderTokenSample::redeemStandingOrderToken($payee, $token->getId());
        $this->assertNotNull($submission);
    }
}