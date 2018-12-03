<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenRequest;
use PHPUnit\Framework\TestCase;
use Tokenio\Http\Request\AccessTokenBuilder;
use Tokenio\Member;
use Tokenio\Util\Strings;
use Tokenio\Util\TestUtil;
use Tokenio\Util\Util;

class AccessTokenTest extends TestCase
{
    const TOKEN_LOOKUP_TIMEOUT_MICRO = 15000000;
    const TOKEN_LOOKUP_POLL_FREQUENCY_MICRO = 1500000;
    const MICROS_IN_SEC = 1000000;

    /** @var \Tokenio\TokenIO */
    protected $tokenIO;
    /** @var Member $member1 */
    private $member1;
    /** @var Member $member2 */
    private $member2;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member1 = $this->tokenIO->createMember(TestUtil::generateAlias());
        $this->member2 = $this->tokenIO->createMember(TestUtil::generateAlias());
    }

    public function testGetAccessToken()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), TestUtil::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();
        $accessToken = $this->member1->createAccessToken($payload);
        $result = $this->member1->getToken($accessToken->getId());

        $this->assertEquals($accessToken, $result);
    }

    public function testGetAccessTokens()
    {
        $this->setUp();
        $address = $this->member1->addAddress(Strings::generateNonce(), TestUtil::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();

        $accessToken = $this->member1->createAccessToken($payload);
        $this->member1->endorseToken($accessToken, Level::STANDARD);
        usleep(self::TOKEN_LOOKUP_POLL_FREQUENCY_MICRO * 5);
        $result = $this->member1->getAccessTokens(null, 2);
        $hasEquity = false;
        /** @var Token $item */
        foreach ($result->getList() as $item) {

            $hasEquity = $accessToken->getId() === $item->getId();
            if ($hasEquity) {
                break;
            }
        }
        $this->assertTrue($hasEquity);
    }

    public function testOnlyOneAccessTokenAllowed()
    {
        $member = $this->tokenIO->createMember(TestUtil::generateAlias());
        $address = $member->addAddress(Strings::generateNonce(), TestUtil::generateAddress());
        $member->createAccessToken(AccessTokenBuilder::createWithAlias($member->getFirstAlias())
            ->forAddress($address->getId())
            ->build());

        $this->expectException('Tokenio\Exception\StatusRuntimeException');

        $member->createAccessToken(AccessTokenBuilder::createWithAlias($member->getFirstAlias())
            ->forAddress($address->getId())
            ->build());
    }

    public function testGetAccessTokenId()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), TestUtil::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();

        $request = new TokenRequest();
        $request->setPayload($payload);
        $tokenRequestId = $this->member2->storeTokenRequest($request);
        $accessToken = $this->member1->createAccessToken($payload, $tokenRequestId);

        $this->member1->endorseToken($accessToken, Level::STANDARD);
        $signature = $this->member1->signTokenRequestState($tokenRequestId, $accessToken->getId(), Strings::generateNonce());
        $this->assertNotEmpty($signature->getSignature());

        $result = $this->tokenIO->getTokenRequestResult($tokenRequestId);
        $this->assertEquals($accessToken->getId(), $result->getTokenId());
        $this->assertEquals($signature->getSignature(), $result->getSignature()->getSignature());

    }

    public function testAuthFlowTest()
    {
        $accessToken = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAll()->build());

        $token = $this->member1->getToken($accessToken->getId());
        $requestId = Strings::generateNonce();
        $originalState = Strings::generateNonce();
        $csrfToken = Strings::generateNonce();

        $tokenRequestUrl = $this->tokenIO->generateTokenRequestUrl($requestId, $originalState, $csrfToken);
        $queryString = parse_url($tokenRequestUrl, PHP_URL_QUERY);
        parse_str($queryString, $queryParams);
        $signature = $this->member1->signTokenRequestState($requestId, $token->getId(), urlencode($queryParams['state']));
        $path = sprintf('path?tokenId=%s&state=%s&signature=%s', $token->getId(), $queryParams['state'], Util::toJson($signature));
        $tokenRequestCallbackUrl = 'http://localhost:80/' . $path;

        $callback = $this->tokenIO->parseTokenRequestCallbackUrl($tokenRequestCallbackUrl, $csrfToken);

        $this->assertEquals($originalState, $callback->getState());
    }

    public function testRequestSignature()
    {
        $token = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAll()->build());
        $signature = $this->member1->signTokenRequestState(Strings::generateNonce(), $token->getId(), Strings::generateNonce());
        $this->assertNotEmpty($signature->getSignature());
    }

    public function testAccessTokenBuilderSetTransferDestinations()
    {
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAllTransferDestinations()->build();
        $accessToken = $this->member1->createAccessToken($payload);
        $result = $this->member1->getToken($accessToken->getId());
        $this->assertEquals($accessToken, $result);
    }
}