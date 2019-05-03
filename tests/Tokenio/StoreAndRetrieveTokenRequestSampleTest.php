<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody;
use Io\Token\Samples\StoreAndRetrieveTokenRequestSample;
use PHPUnit\Framework\TestCase;
use Tokenio\Member;
use Tokenio\TokenRequest;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

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
