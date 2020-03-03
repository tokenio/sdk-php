<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Tokenio\Sample\User\CreateTransferTokenSample;

class RedeemTransferTokenSampleTest extends TestCase
{
    public function testRedeemPaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createUserMember();
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = $payee->createTestBankAccount(1000, "EUR");
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        $this->assertNotNull($transfer);
    }

    public function testRedeemScheduledPaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createUserMember();
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = $payee->createTestBankAccount(1000, "EUR");
        $token = CreateTransferTokenSample::createTransferTokenScheduled($payer,$payeeAlias);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        $this->assertNotNull($transfer);
        $this->assertNotEmpty($transfer->getExecutionDate());
    }
}