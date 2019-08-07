<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use PHPUnit\Framework\TestCase;
use Io\Token\TokenRequest;
use Io\Token\Member;

class TokenRequestTest extends TestCase
{
    const TOKEN_URL = 'https://token.io';

    /** @var \Tokenio\TokenClient */
    protected $tokenIO;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member = $this->tokenIO->createMember(TestUtil::generateAlias());
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }

    public function testAddAndGetTransferTokenRequest()
    {
        $payload = $this->member->createTransferToken(10, 'EUR')
                                ->setToMemberId($this->member->getMemberId())
                                ->build();

        $storedRequest = TokenRequest::builder($payload)->addAllOptions(['redirectUrl' => self::TOKEN_URL])->build();

        $requestId = $this->member->storeTokenRequest($storedRequest);
        $this->assertNotEmpty($requestId);

        $retrievedRequest = $this->tokenIO->retrieveTokenRequest($requestId);
        $this->assertEquals($storedRequest->getTokenPayload(), $retrievedRequest->getPayload());
        $this->assertEquals($requestId, $retrievedRequest->getId());
        foreach ($storedRequest->getOptions() as $k => $v){
            $this->assertEquals($v, $retrievedRequest->getOptions()->offsetGet($k));
        }
    }

    public function testAddAndGetAccessTokenRequest()
    {
        $toMember = new TokenMember();
        $toMember->setId($this->member->getMemberId());

        $resource = new AccessBody\Resource();
        $resource->setAllAddresses(new AccessBody\Resource\AllAddresses());

        $access = new AccessBody();
        $access->setResources([$resource]);

        $payload = new TokenPayload();
        $payload->setTo($toMember)
                ->setAccess($access);

        $storedRequest = TokenRequest::builder($payload)->addAllOptions(['redirectUrl' => self::TOKEN_URL])->build();

        $requestId = $this->member->storeTokenRequest($storedRequest);
        $this->assertNotEmpty($requestId);
        $retrievedRequest = $this->tokenIO->retrieveTokenRequest($requestId);
        $this->assertEquals($storedRequest->getTokenPayload(), $retrievedRequest->getPayload());
        $this->assertEquals($requestId, $retrievedRequest->getId());
        foreach ($storedRequest->getOptions() as $k => $v){
            $this->assertEquals($v, $retrievedRequest->getOptions()->offsetGet($k));
        }

    }

    public function testAddAndGetTokenRequest_NotFound()
    {
        $this->expectException('Io\Token\Exception\StatusRuntimeException');
        $token1 = $this->tokenIO->retrieveTokenRequest('bogus');
        $token2 = $this->tokenIO->retrieveTokenRequest($this->member->getMemberId());

        $this->assertEmpty($token1);
        $this->assertEmpty($token2);
    }

    public function testAddAndGetTokenRequest_WrongMember()
    {
        $payload = $this->member->createTransferToken(10, 'EUR')
                                ->setToMemberId($this->tokenIO->createMember()->getMemberId())
                                ->build();

        $storedRequest = TokenRequest::builder($payload)->build();

        $this->expectException('Io\Token\Exception\StatusRuntimeException');
        $this->member->storeTokenRequest($storedRequest);

    }
}