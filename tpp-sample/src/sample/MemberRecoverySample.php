<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Tokenio\Exception\CryptographicException;
use Tokenio\Security\InMemoryKeyStore;
use Tokenio\Tpp\Member;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Tpp\TokenClient;

class MemberRecoverySample
{
    /**@var Member**/
    public $agentMember;

    /**
     * @param $member Member
     * @throws \Exception
     */
    public function setUpDefaultRecoveryRule($member)
    {
        $member->useDefaultRecoveryRule();
    }

    /**
     * Recover previously-created member, assuming they were
     * configured with a "normal consumer" recovery rule.
     *
     * @param $tokenClient TokenClient
     * @param $alias Alias
     * @return Member
     * @throws \Exception
     */
    public function recoverWithDefaultRule($tokenClient, $alias){
        $verificationId = $tokenClient->beginRecovery($alias);

        $memberId = $tokenClient->getMemberId($alias);
        $cryptoEngine = new TokenCryptoEngine($memberId,new InMemoryKeyStore());

        $recoveredMember = $tokenClient->completeRecoveryWithDefaultRule(
            $memberId,
            $verificationId,
            "1thru6",
            $cryptoEngine);

        $recoveredMember->verifyAlias($verificationId, "1thru6");
        return $recoveredMember;
    }

    /**
     * this simple sample uses a no op
     * @param $memberId string
     */
    private function tellRecoveryAgentMemberId($memberId){}

    /**
     * Illustrate setting up a recovery rule more complex than "normal consumer"
     * mode, without the "normal consumer" shortcuts.
     *
     * @param $newMember Member
     * @param $tokenClient TokenClient
     * @param $agentAlias Alias
     * @throws \Exception
     */
    public function setUpComplexRecoveryRule($newMember, $tokenClient, $agentAlias)
    {
        $this->tellRecoveryAgentMemberId($newMember->getMemberId());

        $agentId = $tokenClient->getMemberId($agentAlias);
        $recoveryRule = new RecoveryRule();
        $recoveryRule->setPrimaryAgent($agentId);
        $newMember->addRecoveryRule($recoveryRule);
    }


    /**
     * this simple sample approves everybody
     * @param $memberId string
     * @return bool
     */
    private function checkMemberId($memberId){
        return true;
    }

    /**
     * Illustrate how a recovery agent signs an authorization.
     *
     * @param $authorization Authorization
     * @return Signature if authorization is legitimate then return Signature; else error
     */
    public function getRecoveryAgentSignature($authorization){
        $isCorrect = $this->checkMemberId($authorization->getMemberId());
        if($isCorrect){
            return $this->agentMember->authorizeRecovery($authorization);
        }

        throw new \RuntimeException("I don't authorize this.");
    }

    /**
     * Illustrate recovery using a not-normal-"consumer mode" recovery agent.
     *
     * @param $tokenClient TokenClient
     * @param $alias Alias
     * @return Member recovered member
     * @throws CryptographicException
     * @throws \Exception
     */
    public function recoverWithComplexRule($tokenClient, $alias)
    {
        $memberId = $tokenClient->getMemberId($alias);
        $cryptoEngine = new TokenCryptoEngine($memberId, new InMemoryKeyStore());
        $newKey = $cryptoEngine->generateKey(Level::PRIVILEGED);

        $verificationId = $tokenClient->beginRecovery($alias);
        $authorization = $tokenClient->createRecoveryAuthorization($memberId, $newKey);

        $agentSignature = $this->getRecoveryAgentSignature($authorization);

        /* @var $mro MemberRecoveryOperation  */
        $mro = new MemberRecoveryOperation();
        $mro->setAuthorization($authorization);
        $mro->setAgentSignature($agentSignature);


        /** @var Member $recoveredMember */
        $recoveredMember = $tokenClient->completeRecovery($memberId, array($mro), $newKey, $cryptoEngine);

        $recoveredMember->verifyAlias($verificationId, "1thru6");

        return $recoveredMember;
    }

}