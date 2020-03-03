<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;

class NotifySampleTest extends TestCase
{
    public function testNotifyPaymentRequestSample()
    {
        $tokenClient = TestUtil::createClient();
        $payerAlias = TestUtil::randomAlias();
        $payer = $tokenClient->createMember($payerAlias);
        $payee = TestUtil::createMemberAndLinkAccounts($tokenClient);
        LinkMemberAndBankSample::linkBankAccounts($payer);
        $status = NotifySample::notifyPaymentRequest($tokenClient, $payee, $payerAlias);
        $this->assertNotNull($status);
    }
}