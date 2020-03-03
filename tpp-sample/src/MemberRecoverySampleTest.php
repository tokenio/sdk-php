<?php


namespace Tokenio\Sample\Tpp;


use PHPUnit\Framework\TestCase;

class MemberRecoverySampleTest extends TestCase
{
    public function testRecoveryDefault()
    {
        $tokenClient = TestUtil::createClient();
        $mrs = new MemberRecoverySample();

        //set up
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
        // set up
        $originalAlias = TestUtil::randomAlias();
        $originalMember = $tokenClient->createMember($originalAlias);
        $mrs->setUpComplexRecoveryRule($originalMember, $tokenClient, $agentAlias);
        // recover
        $otherTokenClient = TestUtil::createClient();
        $recoveredMember = $mrs->recoverWithComplexRule($otherTokenClient, $originalAlias);
        // make sure it worked
        $recoveredAlias = $recoveredMember->firstAlias();
        $this->assertEquals($originalAlias, $recoveredAlias);
    }
}