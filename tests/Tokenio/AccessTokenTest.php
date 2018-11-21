<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\Token;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;
use Tokenio\Exception;
use Tokenio\Http\Request\AccessTokenBuilder;
use Tokenio\Member;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class AccessTokenTest extends TokenBaseTest
{
    const TOKEN_LOOKUP_TIMEOUT_MICRO = 15000000;
    const TOKEN_LOOKUP_POLL_FREQUENCY_MICRO = 1000000;

    /** @var Member $member1 */
    private $member1;
    /** @var Member $member2 */
    private $member2;

    protected function setUp()
    {
        $this->member1 = $this->tokenIO->createMember(self::generateAlias());
        $this->member2 = $this->tokenIO->createMember(self::generateAlias());
    }

    public function testGetAccessToken()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();

        $accessToken = $this->member1->createAccessToken($payload);
        $result = $this->member1->getToken($accessToken->getId());

        $this->assertEquals($accessToken, $result);
    }

    public function testGetAccessTokens()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();

        $accessToken = $this->member1->createAccessToken($payload);
        $this->member1->endorseToken($accessToken, Level::STANDARD);
        for($start = microtime(true); ;){
            try{
                //action invoke
                $result = $this->member1->getAccessTokens(null, 2);
                $hasEquity = false;
                /** @var Token $item */
                foreach ($result->getList() as $item){
                    $hasEquity = $accessToken->getId() === $item->getId();
                    if($hasEquity){
                        break;
                    }
                }
                $this->assertTrue($hasEquity);
            }catch (Exception $exception){
                if(microtime(true) - $start < self::TOKEN_LOOKUP_TIMEOUT_MICRO){
                    usleep(self::TOKEN_LOOKUP_POLL_FREQUENCY_MICRO);
                }
            }
        }
    }

    public function testOnlyOneAccessTokenAllowed()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member1->getFirstAlias())
                                                                                            ->forAddress($address->getId())
                                                                                            ->build());

        $this->expectException('AggregateException');

        $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member1->getFirstAlias())
                                                                                            ->forAddress($address->getId())
                                                                                            ->build());
    }

    public function testCreateAccessTokenIdempotent()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $accessToken = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member1->getFirstAlias())
                                                                                                           ->forAddress($address->getId())
                                                                                                           ->build());

        $this->member1->endorseToken($this->member1->createAccessToken($accessToken->getPayload()), Level::STANDARD);
        $this->member1->endorseToken($this->member1->createAccessToken($accessToken->getPayload()), Level::STANDARD);

        for($start = microtime(true); ;){
            try{
                //action invoke
                $result = $this->member1->getAccessTokens(null, 2);
                $this->assertCount(1, $result->getList());
            }catch (Exception $exception){
                if(microtime(true) - $start < self::TOKEN_LOOKUP_TIMEOUT_MICRO){
                    usleep(self::TOKEN_LOOKUP_POLL_FREQUENCY_MICRO);
                }
            }
        }
    }

    public function testCreateAddressAccessToken()
    {
        $address1 = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $address2 = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $accessToken = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())
                                                                                                           ->forAddress($address1->getId())
                                                                                                           ->build());

        $this->member1->endorseToken($accessToken, Level::STANDARD);
        $representable = $this->member2->forAccessToken($accessToken->getId());

        $this->assertEquals($address1, $representable->getAddress($address1->getId()));

        $this->expectException('AggregateException');
        $representable->getAddress($address2->getId());

    }

    public function testCreateAddressesAccessToken()
    {
        $accessToken = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member1->getFirstAlias())
                                                                                                           ->forAllAddresses()
                                                                                                           ->build());

        $this->member1->endorseToken($accessToken, Level::STANDARD);
        $address1 = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $address2 = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());

        $representable = $this->member2->forAccessToken($accessToken->getId());
        $result = $representable->getAddress($address2->getId());

        $this->assertEquals($result, $address2);
        $this->assertNotEquals($result, $address1);
    }

    public function testGetAccessTokenId()
    {
        $address = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $payload = AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAddress($address->getId())->build();

        $request = new TokenRequest();
        $request->setPayload($payload);
        $tokenRequestId = $this->member2->storeTokenRequest($request);
        $accessToken = $this->member1->createAccessToken($payload, $tokenRequestId);

        $this->member1->endorseToken($accessToken,Level::STANDARD);
        $signature = $this->member1->signTokenRequestState($tokenRequestId, $accessToken->getId(), Strings::generateNonce());
        $this->assertNotEmpty($signature->getSignature());

        $result = $this->tokenIO->getTokenRequestResult($tokenRequestId);
        $this->assertEquals($accessToken->getId(), $result->getTokenId());
        $this->assertEquals($signature->getSignature(), $result->getSignature()->getSignature());

    }

    public function testUseAccessTokenConcurrently()
    {
        $address1 = $this->member1->addAddress(Strings::generateNonce(), self::generateAddress());
        $address2 = $this->member2->addAddress(Strings::generateNonce(), self::generateAddress());

        $user = $this->tokenIO->createMember(self::generateAlias());

        $accessToken1 = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member1->getFirstAlias())
                                                                                                            ->forAddress($address1->getId())
                                                                                                            ->build());

        $accessToken2 = $this->member2->createAccessToken(AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())
                                                                                                            ->forAddress($address2->getId())
                                                                                                            ->build());

        $this->member1->endorseToken($accessToken1,Level::STANDARD);
        $this->member2->endorseToken($accessToken2,Level::STANDARD);

        $representable1 = $this->member1->forAccessToken($accessToken1->getId());
        $representable2 = $this->member2->forAccessToken($accessToken2->getId());

        $addressRecord1 = $representable1->getAddress($address1->getId());
        $addressRecord2 = $representable2->getAddress($address2->getId());
        $addressRecord3 = $representable1->getAddress($address1->getId());

        $this->assertEquals($addressRecord1, $address1);
        $this->assertEquals($addressRecord2, $address2);
        $this->assertEquals($addressRecord3, $address1);
    }

    public function testAuthFlowTest()
    {
        $accessToken = $this->member1->createAccessToken(AccessTokenBuilder::createWithAlias($this->member2->getFirstAlias())->forAll()->build());

        $token = $this->member1->getToken($accessToken->getId());
        $requestId = Strings::generateNonce();
        $originalState = Strings::generateNonce();
        $csrfToken = Strings::generateNonce();

        $tokenRequestUrl = $this->tokenIO->generateTokenRequestUrl($requestId, $originalState, $csrfToken);
        $stateParameter = parse_url($tokenRequestUrl, PHP_URL_QUERY)['state'];
        $signature = $this->member1->signTokenRequestState($requestId, $token->getId(), urlencode($stateParameter));
        $path = sprintf('path?tokenId=%s&state=%s&signature=%s', $token->getId(), urlencode($stateParameter), Util::toJson($signature));
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