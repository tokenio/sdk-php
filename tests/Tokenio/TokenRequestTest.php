<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\ProfilePictureSize;
use Io\Token\Proto\Common\Token\TokenPayload;
use Io\Token\Proto\Common\Token\TokenRequest;

class TokenRequestTest extends TokenBaseTest
{
    public function testAddAndGetTransferTokenRequest()
    {
        $storedRequest = new TokenRequest();

        $payload = new TokenPayload();
//        $payload->
        $storedRequest->setPayload($payload)
                      ->setOptions([]);
    }

    /*
     [Test]
        public void AddAndGetTransferTokenRequest()
        {
            var storedRequest = new TokenRequest
            {
                Payload = memberSync.CreateTransferToken(10.0, "EUR")
                    .SetToMemberId(memberSync.MemberId())
                    .BuildPayload(),
                Options = {{TokenRequestOptions.redirectUrl.ToString(), tokenUrl}}
            };
            var requestId = memberSync.StoreTokenRequest(storedRequest);
            Assert.IsNotEmpty(requestId);
            storedRequest.Id = requestId;
            var retrievedRequest = tokenIO.RetrieveTokenRequest(requestId);
            Assert.AreEqual(storedRequest, retrievedRequest);
        }


        [Test]
        public void AddAndGetAccessTokenRequest()
        {
            var storedRequest = new TokenRequest
            {
                Payload = new TokenPayload
                {
                    To = new TokenMember
                    {
                        Id = memberSync.MemberId()
                    },
                    Access = new AccessBody
                    {
                        Resources =
                        {
                            new Resource
                            {
                                AllAddresses = new AllAddresses()
                            }
                        }
                    }
                },
                Options = {{TokenRequestOptions.redirectUrl.ToString(), tokenUrl}}
            };
            var requestId = memberSync.StoreTokenRequest(storedRequest);
            Assert.IsNotEmpty(requestId);
            storedRequest.Id = requestId;
            var retrievedRequest = tokenIO.RetrieveTokenRequest(requestId);
            Assert.AreEqual(storedRequest, retrievedRequest);
        }


        [Test]
        public void AddAndGetTokenRequest_NotFound()
        {
            Assert.Throws<AggregateException>(() => tokenIO.RetrieveTokenRequest("bogus"));
            Assert.Throws<AggregateException>(() => tokenIO.RetrieveTokenRequest(memberSync.MemberId()));
        }

        [Test]
        public void AddAndGetTokenRequest_WrongMember()
        {
            var storedRequest = new TokenRequest
            {
                Payload = memberSync.CreateTransferToken(10.0, "EUR")
                    .SetToMemberId(tokenIO.CreateMember().MemberId())
                    .BuildPayload()
            };
            Assert.Throws<AggregateException>(() => memberSync.StoreTokenRequest(storedRequest));
        }
    }*/
}