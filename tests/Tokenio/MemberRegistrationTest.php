<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\Util\TestUtil;

class MemberRegistrationTest extends TestCase
{
    /** @var \Tokenio\TokenIO */
    protected $tokenIO;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
    }

    public function testCreateMember()
    {
        $alias = TestUtil::generateAlias();
        $member = $this->tokenIO->createMember($alias);
        $this->assertCount(3, $member->getKeys());
    }

    public function testCreateMember_noAlias()
    {
        $member = $this->tokenIO->createMember();
        $this->assertEmpty($member->getAliases());
        $this->assertCount(3, $member->getKeys());
    }

    public function testLoginMember()
    {
        $alias = TestUtil::generateAlias();
        $member = $this->tokenIO->createMember($alias);
        $loggedIn = $this->tokenIO->getMember($member->getMemberId());

        $expectedAliases = array();
        foreach ($member->getAliases() as $alias){
            $expectedAliases[] = $alias;
        }
        $actualAliases = array();
        foreach ($loggedIn->getAliases() as $alias){
            $actualAliases[] = $alias;
        }
        sort($expectedAliases);
        sort($actualAliases);
        $this->assertEquals($expectedAliases, $actualAliases);

        $expectedKeys = array();
        foreach ($member->getKeys() as $key){
            $expectedKeys[] = $key;
        }
        $actualKeys = array();
        foreach ($loggedIn->getKeys() as $key){
            $actualKeys[] = $key;
        }
        sort($expectedKeys);
        sort($actualKeys);
        $this->assertEquals($expectedKeys, $actualKeys);
    }

    public function testAddAlias()
    {
        $alias1 = TestUtil::generateAlias();
        $alias2 = TestUtil::generateAlias();

        $member = $this->tokenIO->createMember($alias1);
        $receivedAliases = TestUtil::repeatedFieldsToArray($member->getAliases());
        $this->assertEquals($receivedAliases, [$alias1]);

        $member->addAlias($alias2);
        $receivedAliases = TestUtil::repeatedFieldsToArray($member->getAliases());
        $expected = [$alias1,$alias2];
        sort($expected);
        sort($receivedAliases);
        $this->assertEquals($expected, $receivedAliases);

    }

    public function testRemoveAlias()
    {
        $alias1 = TestUtil::generateAlias();
        $alias2 = TestUtil::generateAlias();

        $member = $this->tokenIO->createMember($alias1);
        $actualAliases = TestUtil::repeatedFieldsToArray($member->getAliases());
        $this->assertEquals([$alias1], $actualAliases);

        $member->addAlias($alias2);
        $actualAliases = TestUtil::repeatedFieldsToArray($member->getAliases());
        $expectedAliases = [$alias1, $alias2];
        sort($actualAliases);
        sort($expectedAliases);
        $this->assertEquals($expectedAliases, $actualAliases);

        $member->removeAlias($alias2);
        $actualAliases = TestUtil::repeatedFieldsToArray($member->getAliases());
        $this->assertEquals([$alias1], $actualAliases);
    }

    public function testAliasDoesNotExist()
    {
        $alias = TestUtil::generateAlias();
        $this->assertFalse($this->tokenIO->isAliasExists($alias));
    }

    public function testAliasExists()
    {
        $alias = TestUtil::generateAlias();
        $member = $this->tokenIO->createMember($alias);
        $this->assertTrue($this->tokenIO->isAliasExists($alias));
    }

    public function testRecovery()
    {
        $alias = TestUtil::generateAlias();
        $member = $this->tokenIO->createMember($alias);
        $member->useDefaultRecoveryRule();
        $verificationId = $this->tokenIO->beginRecovery($alias);
        $recovered = $this->tokenIO->completeRecoveryWithDefaultRule($member->getMemberId(), $verificationId, 'code');

        $this->assertEquals($member->getMemberId(), $recovered->getMemberId());
        $this->assertCount(3, $recovered->getKeys());
        $this->assertEmpty($recovered->getAliases());
        $this->assertFalse($this->tokenIO->isAliasExists($alias));

        $recovered->verifyAlias($verificationId, 'code');
        $this->assertTrue($this->tokenIO->isAliasExists($alias));
        $actualAliases = TestUtil::repeatedFieldsToArray($recovered->getAliases());
        $this->assertEquals([$alias], $actualAliases);
    }

    public function testRecoveryWithSecondaryAgent()
    {
        $this->setUp();
        $alias = TestUtil::generateAlias();
        $member = $this->tokenIO->createMember($alias);
        $memberId = $member->getMemberId();
        $primaryAgentId = $member->getDefaultAgent();
        $secondaryAgent = $this->tokenIO->createMember(self::generateAlias());
        $unusedSecondaryAgent = $this->tokenIO->createMember(self::generateAlias());

        $recoveryRule = new RecoveryRule();
        $recoveryRule->setPrimaryAgent($primaryAgentId)
            ->setSecondaryAgents([$secondaryAgent->getMemberId(), $unusedSecondaryAgent->getMemberId()]);

        $member->addRecoveryRule($recoveryRule);
        $cryptoEngine = new TokenCryptoEngine($memberId, $this->keyStore);
        $key = $cryptoEngine->generateKey(Level::PRIVILEGED);
        $verificationId = $this->tokenIO->beginRecovery($alias);
        $authorization = new Authorization();
        $authorization->setMemberId($memberId)
            ->setMemberKey($key)
            ->setPrevHash($member->getLastHash());

        $signature = $secondaryAgent->authorizeRecovery($authorization);
        $op1 = $this->tokenIO->getRecoveryAuthorization($verificationId,'code', $key);
        $op2 = new MemberRecoveryOperation();
        $op2->setAuthorization($authorization)
            ->setAgentSignature($signature);

        $recovered = $this->tokenIO->completeRecovery($memberId, [$op1, $op2], $key, $cryptoEngine);

        $this->assertEquals($member->getMemberId(), $recovered->getMemberId());
        $this->assertCount(3, $recovered->getKeys());
        $this->assertEmpty($recovered->getAliases());
        $this->assertFalse($this->tokenIO->isAliasExists($alias));

        $recovered->verifyAlias($verificationId, 'code');
        $this->assertTrue($this->tokenIO->isAliasExists($alias));
        $this->assertEquals([$alias], $recovered->getAliases());
    }
}