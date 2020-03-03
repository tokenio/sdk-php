<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use PHPUnit\Framework\TestCase;

class PollNotificationsSampleTest extends TestCase
{
    public function testNotifyPaymentRequestSample()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payee = PollNotificationsSample::createMember($tokenClient);
        $payeeAlias = $payee->firstAlias();
        $account = LinkMemberAndBankSample::linkBankAccounts($payer);
        LinkMemberAndBankSample::linkBankAccounts($payee);
        $token = new TransferDestination\Token();
        $token->setMemberId($payee->getMemberId());
        $tokenDestination = new TransferDestination();
        $tokenDestination->setToken($token);

        /* @var $builder \Tokenio\User\TransferTokenBuilder */
        $builder = $payer->createTransferToken(null, null, 100, "EUR");
        $builder->setAccountId($account->id())->setToAlias($payeeAlias)->addDestination($tokenDestination);
        $result = $payer->prepareTransferToken($builder);
        $token = $payer->createToken($result->getTokenPayload(), null,Level::STANDARD);
        $transfer = $payee->redeemToken($token);
        $notification = PollNotificationsSample::poll($payee);
        $this->assertTrue($notification);
    }
}

