<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;

class MemberRecoverySampleTest extends TestCase
{
    public function testRecoveryDefault()
    {
        $tokenClient = TestUtil::createClient();
        $mrs = new MemberRecoverySample();
        $originalAlias = TestUtil::randomAlias();
        $originalMember = $tokenClient->createMember($originalAlias);
        $mrs->setUpDefaultRecoveryRule($originalMember);

        $otherTokenClient = TestUtil::createClient();
        $recoveredMember = $mrs->recoverWithDefaultRule($otherTokenClient, $originalAlias);
        $recoveredAlias = $recoveredMember->firstAlias();
        $this->assertEquals($originalAlias, $recoveredAlias);
    }

    public function testRecoveryComplex()
    {
        $tokenClient = TestUtil::createClient();
        $mrs = new MemberRecoverySample();

        $agentTokenIO = TestUtil::createClient();
        $agentAlias = TestUtil::randomAlias();
        $agentMember = $agentTokenIO->createMember($agentAlias);
        $mrs->agentMember = $agentMember;
        $originalAlias = TestUtil::randomAlias();
        $originalMember = $tokenClient->createMember($originalAlias);
        $mrs->setUpComplexRecoveryRule($originalMember, $tokenClient, $agentAlias);
        $otherTokenClient = TestUtil::createClient();
        $recoveredMember = $mrs->recoverWithComplexRule($otherTokenClient, $originalAlias);
        $recoveredAlias = $recoveredMember->firstAlias();
        $this->assertEquals($originalAlias, $recoveredAlias);
    }
}