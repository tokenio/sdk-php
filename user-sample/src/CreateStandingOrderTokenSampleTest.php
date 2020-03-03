<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Tokenio\User\Member;
use Tokenio\User\TokenClient;

class CreateStandingOrderTokenSampleTest extends TestCase
{
    public function testCreateStandingOrderToken()
    {
        $tokenClient = TestUtil::createClient();
        /** @var Member $payer */
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $token = CreateStandingOrderTokenSample::createStandingOrderToken($payer, $payeeAlias, Level::STANDARD);
        $this->assertNotNull($token);
    }
}