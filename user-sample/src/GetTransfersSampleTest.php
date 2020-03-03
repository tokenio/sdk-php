<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\TokenOperationResult\Status;
use PHPUnit\Framework\TestCase;

class GetTransfersSampleTest extends TestCase
{
    public function testGetTransfers()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        GetTransfersSample::getTransfersSample($payer);
    }

    public function testGetTransferTokens()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);
        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        GetTransfersSample::getTransferTokensSample($payer);
    }

    public function testGetTransfer()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);

        $redeemedTransfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        $gotTransfer = GetTransfersSample::getTransferSample($payee, $redeemedTransfer->getId());
        $this->assertEquals($redeemedTransfer, $gotTransfer);
    }
}