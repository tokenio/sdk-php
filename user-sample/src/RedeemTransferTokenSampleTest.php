<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;

class RedeemTransferTokenSampleTest extends TestCase
{
    public function testRedeemPaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        $this->assertNotNull($transfer);
    }

    public function testRedeemScheduledPaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferTokenScheduled($payer, $payeeAlias);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        $this->assertNotNull($transfer);
        $this->assertNotEmpty($transfer->getExecutionDate());
    }
}