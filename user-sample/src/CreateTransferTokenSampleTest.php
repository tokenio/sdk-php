<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;

class CreateTransferTokenSampleTest extends TestCase
{
    public function testCreatePaymentToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);
        $this->assertNotNull($token);
    }

    public function testCreatePaymentTokenWithOtherOptions()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payee = $tokenClient->createMember(TestUtil::randomAlias());

        $token = CreateTransferTokenSample::createTransferTokenWithOtherOptions($payer , $payee->getMemberId());
        $this->assertNotNull($token);
    }

    public function testCreatePaymentTokenToDestination()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $token = CreateTransferTokenSample::createTransferTokenToDestination($payer, $payeeAlias);
        $this->assertNotNull($token);
    }

}