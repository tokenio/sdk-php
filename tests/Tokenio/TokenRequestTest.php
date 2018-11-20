<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;

class TokenRequestTest extends TokenBaseTest
{
    const TOKEN_URL = 'https://token.io';

    public function testAddAndGetTransferTokenRequest()
    {
        $storedRequest = new TokenRequest();
        $payload = $this->member->createTransferToken(10, 'EUR')
                                ->setToMemberId($this->member->getMemberId())
                                ->build();

        $storedRequest->setPayload($payload)
                      ->setOptions(['redirectUrl' => self::TOKEN_URL]);

        $requestId = $this->member->storeTokenRequest($storedRequest);
        $this->assertNotEmpty($requestId);
        $storedRequest->setId($requestId);

        $retrievedRequest = $this->tokenIO->retrieveTokenRequest($requestId);
        $this->assertEquals($storedRequest, $retrievedRequest);
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

        $storedRequest = new TokenRequest();
        $storedRequest->setPayload($payload)
                      ->setOptions(['redirectUrl' => self::TOKEN_URL]);

        $requestId = $this->member->storeTokenRequest($storedRequest);
        $this->assertNotEmpty($requestId);
        $storedRequest->setId($requestId);
        $retreivedRequest = $this->tokenIO->retrieveTokenRequest($requestId);
        $this->assertEquals($storedRequest, $retreivedRequest);
    }

    public function testAddAndGetTokenRequest_NotFound()
    {
        $this->expectException('AggregateException');
        $this->tokenIO->retrieveTokenRequest('bogus');
        $this->tokenIO->retrieveTokenRequest($this->member->getMemberId());
    }

    public function testAddAndGetTokenRequest_WrongMember()
    {
        $payload = $this->member->createTransferToken(10, 'EUR')
                                ->setToMemberId($this->tokenIO->createMember()->getMemberId())
                                ->build();

        $storedRequest = new TokenRequest();
        $storedRequest->setPayload($payload);

        $this->expectException('AggregateException');
        $this->member->storeTokenRequest($storedRequest);

    }
}