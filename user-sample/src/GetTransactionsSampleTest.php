<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;

class GetTransactionsSampleTest extends TestCase
{
    public function testGetTransactions()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);

        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());

        GetTransactionsSample::getTransactionsSample($payer);
        GetTransactionsSample::getTransactionsByDateSample($payer);

        $transaction = GetTransactionsSample::getTransactionSample($payer, $transfer);
        $this->assertEquals($token->getId(), $transaction->getTokenId());
    }

    public function testAccountGetTransactions()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $payeeAccount = LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);

        $transfer = RedeemTransferTokenSample::redeemTransferToken($payee, $payeeAccount->id(), $token->getId());
        GetTransactionsSample::accountGetTransactionsSample($payer);

        $transaction = GetTransactionsSample::accountGetTransactionSample($payer, $transfer);
        $this->assertEquals($token->getId(), $transaction->getTokenId());
    }
}