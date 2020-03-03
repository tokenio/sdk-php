<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenSignature;
use PHPUnit\Framework\TestCase;

class GetTokensSampleTest extends TestCase
{
    public function testGetToken()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createMemberAndLinkAccounts($tokenClient);
        $granteeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($granteeAlias);
        $token = CreateTransferTokenSample::createTransferToken($payer, $granteeAlias, Level::LOW);
        $this->assertEquals($token->getId(), GetTokensSample::getToken($payer, $token->getId())->getId());

        $signatureList = GetTokensSample::getToken($payer, $token->getId())->getPayloadSignatures();
        $result = array();
        foreach ($signatureList as $signature)
        {
            /** @var  TokenSignature $signature */
            if($signature->getAction() === TokenSignature\Action::CANCELLED)
            {
                $result[] = $signature;
            }
        }
        $this->assertEmpty($result);

        $payer->cancelToken($token);

        $newSignatureList = GetTokensSample::getToken($payer, $token->getId())->getPayloadSignatures();
        $newResult = array();
        foreach ($newSignatureList as $signature)
        {
            /** @var  TokenSignature $signature */
            if($signature->getAction() === TokenSignature\Action::CANCELLED)
            {
                $newResult[] = $signature;
            }
        }
        $this->assertNotEmpty($newResult);
    }
}