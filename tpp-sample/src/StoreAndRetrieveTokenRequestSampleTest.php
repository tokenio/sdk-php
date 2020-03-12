<?php


namespace Tokenio\Sample\Tpp;

use PHPUnit\Framework\TestCase;

class StoreAndRetrieveTokenRequestSampleTest extends TestCase
{

    public function testStoreAndRetrieveTransferToken()
    {
        $tokenClient = TestUtil::createClient();
        $payee = $tokenClient->createMember(TestUtil::randomAlias());
        $requestId = StoreAndRetrieveTokenRequestSample::storeTransferTokenRequest($payee);
        $request = $tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }

}