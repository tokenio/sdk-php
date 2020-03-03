<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\TokenSignature;
use PHPUnit\Framework\TestCase;
use Tokenio\Sample\User\CreateTransferTokenSample;

class GetTokensSampleTest extends TestCase
{
    public function testGetTokenTest()
    {
        $tokenClient = TestUtil::createClient();
        $payer = TestUtil::createUserMember();
        $payeeAlias = TestUtil::randomAlias();
        $payee = $tokenClient->createMember($payeeAlias);
        $token = CreateTransferTokenSample::createTransferToken($payer, $payeeAlias, Level::LOW);

        $this->assertEquals($token->getId(), GetTokensSample::getToken($payee, $token->getId())->getId());
        $signatureList = GetTokensSample::getToken($payee, $token->getId())->getPayloadSignatures();
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

        $payee->cancelToken($token);

        $newSignatureList = GetTokensSample::getToken($payee, $token->getId())->getPayloadSignatures();
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