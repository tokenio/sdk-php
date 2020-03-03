<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Transferinstructions\TransferDestination;
use PHPUnit\Framework\TestCase;
use Tokenio\Util\Util;

class StoreAndRetrieveTokenRequestSampleTest extends TestCase
{
    /**
     * @var $setTransferDestinationsUrl string
     */
    var $setTransferDestinationsUrl= "https://tpp-sample.com/callback/transferDestinations";

    /**
     * @var $setTransferDestinationsCallback string
     */
    var $setTransferDestinationsCallback= "https://tpp-sample.com/callback/"
    ."transferDestinations?supportedTransferDestinationType=FASTER_PAYMENTS&"
    ."supportedTransferDestinationType=SEPA&bankName=Iron&country=UK";


    public function testStoreAndRetrieveTransferToken()
    {
        $tokenClient = TestUtil::createClient();
        $payee = $tokenClient->createMember(TestUtil::randomAlias());
        $requestId = StoreAndRetrieveTokenRequestSample::storeTransferTokenRequest($payee);
        $request = $tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }


    /**
     * @throws \ReflectionException
     */
    public function testStoreAndRetrieveAccessToken()
    {
        $tokenClient = TestUtil::createClient();
        $grantee = $tokenClient->createMember(TestUtil::randomAlias());
        $requestId = StoreAndRetrieveTokenRequestSample::storeAccessTokenRequest($grantee);
        $request = $tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }


    public function testStoreTokenRequestAndSetTransferDestinations()
    {
        $tokenClient = TestUtil::createClient();
        $payee = $tokenClient->createMember(TestUtil::randomAlias());
        $requestId = StoreAndRetrieveTokenRequestSample::storeTransferTokenRequestWithDestinationsCallback(
            $payee, $this->setTransferDestinationsUrl
        );

        StoreAndRetrieveTokenRequestSample::setTokenRequestTransferDestinations($payee, $requestId, $tokenClient, $this->setTransferDestinationsCallback);

        $request = $tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);

        $this->assertNotEquals(0, $request->getTokenRequestPayload()
                                                    ->getTransferBody()
                                                    ->getInstructions()
                                                    ->getTransferDestinations()->count());
        /** @var TransferDestination $des */
        $des = $request->getTokenRequestPayload()
            ->getTransferBody()->getInstructions()->getTransferDestinations()[0];
        $this->assertTrue($des->getFasterPayments() != null);
    }

}