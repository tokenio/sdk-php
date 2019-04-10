<?php


namespace Sample\Tokenio;


use http\Exception\RuntimeException;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation;
use Io\Token\Proto\Common\Member\MemberRecoveryOperation\Authorization;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Tokenio\Member;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\TokenClient;

class MemberRecoverySample
{

    /**@var Member**/
    public $agentMember;

    /**
     * @param $member Member
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
     */
    public function recoverWithDefaultRule($tokenClient, $alias){
        $verificationId = $tokenClient->beginRecovery($alias);

        $memberId = $tokenClient->getMemberId($alias);
        $cryptoEngine = new TokenCryptoEngine($memberId,
            new UnsecuredFileSystemKeyStore(__DIR__ ."/keys"));

        $recoveredMember = $tokenClient->completeRecoveryWithDefaultRule(
            $memberId,
            $verificationId,
            "1thru6",
            $cryptoEngine);

        $recoveredMember->verifyAlias($verificationId, "1thru6");
        return $recoveredMember;
    }

    private function tellRecoveryAgentMemberId($memberId){}

    /**
     * Illustrate setting up a recovery rule more complex than "normal consumer"
     * mode, without the "normal consumer" shortcuts.
     *
     * @param $newMember Member
     * @param $tokenClient TokenClient
     * @param $agentAlias Alias
     */
    public function setUpComplexRecoveryRule($newMember, $tokenClient, $agentAlias)
    {
        // setUpComplex begin snippet to include in docs
        // Someday in the future, this user might ask the recovery agent
        // "Please tell Token that I am the member with ID m:12345678 ."
        // While we're setting up this new member, we need to tell the
        // recovery agent the new member ID so the agent can "remember" later.
        $this->tellRecoveryAgentMemberId($newMember->getMemberId());

        $agentId = $tokenClient->getMemberId($agentAlias);
        $recoveryRule = new RecoveryRule();
        $recoveryRule->setPrimaryAgent($agentId);
        $newMember->addRecoveryRule($recoveryRule);
    }

    /* this simple sample approves everybody */
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

        throw new RuntimeException("I don't authorizre this.");
    }

    /**
     * Illustrate recovery using a not-normal-"consumer mode" recovery agent.
     *
     * @param $tokenClient TokenClient
     * @param $alias Alias
     * @return Member recovered member
     */
    public function recoverWithComplexRule($tokenClient, $alias)
    {
        $memberId = $tokenClient->getMemberId($alias);
        $cryptoEngine = new TokenCryptoEngine($memberId, new UnsecuredFileSystemKeyStore(__DIR__."/keys"));
        $newKey = $cryptoEngine->generateKey(Level::PRIVILEGED);

        $verificationId = $tokenClient->beginRecovery($alias);
        $authorization = $tokenClient->createRecoveryAuthorization($memberId, $newKey);

        // ask recovery agent to verify that I really am this member
        $agentSignature = $this->getRecoveryAgentSignature($authorization);

        // We have all the signed authorizations we need.
        // (In this example, "all" is just one.)
        $mro = new MemberRecoveryOperation();
        $mro->setAuthorization($authorization);
        $mro->setAgentSignature($agentSignature);

        $recoveredMember = $tokenClient->completeRecovery($memberId, array($mro), $newKey, $cryptoEngine);
        // after recovery, aliases aren't verified

        // In the real world, we'd prompt the user to enter the code emailed to them.
        // Since our test member uses an auto-verify email address, any string will work,
        // so we use "1thru6".
        $recoveredMember->verifyAlias($verificationId, "1thru6");

        return $recoveredMember;
    }

}