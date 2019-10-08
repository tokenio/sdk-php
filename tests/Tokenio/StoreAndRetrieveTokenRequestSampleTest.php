<?php

namespace Test\Tokenio;

use Io\Token\Samples\StoreAndRetrieveTokenRequestSample;
use PHPUnit\Framework\TestCase;
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
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }


    public function testStoreAccessTokenRequest()
    {
        $requestId = StoreAndRetrieveTokenRequestSample::storeAccessTokenRequest($this->member);
        $request = $this->tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }

    public function testStoreTransferTokenRequest()
    {
        $requestId = StoreAndRetrieveTokenRequestSample::storeTransferTokenRequest($this->member);
        $request = $this->tokenClient->retrieveTokenRequest($requestId);
        $this->assertNotNull($request);
    }
}
