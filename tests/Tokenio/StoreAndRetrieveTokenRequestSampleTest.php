<?php

namespace Test\Tokenio;

use PHPUnit\Framework\TestCase;
use Io\Token\Sample\Tokenio\StoreAndRetrieveTokenRequestSample;
use Tokenio\Member;

class StoreAndRetrieveTokenRequestSampleTest extends TestCase
{
    /** @var \Tokenio\TokenClient */
    protected $tokenClient;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenClient = TestUtil::initializeSDK();
        $this->member = $this->tokenClient->createMember(TestUtil::generateAlias());
        echo "Setup called";
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }

    public function testStoreTransferTokenRequest()
    {
        $requestId = StoreAndRetrieveTokenRequestSample::storeTransferTokenRequest($this->member);
        echo " Transfer Token req " . $requestId;
        $request = $this->tokenClient->retrieveTokenRequest($requestId);

        $this->assertNotNull($request);
    }

    public function testStoreAccessTokenRequest()
    {
        $requestId = StoreAndRetrieveTokenRequestSample::storeAccessTokenRequest($this->member);
        echo "Access Token req " . $requestId;
        $request = $this->tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }

}
