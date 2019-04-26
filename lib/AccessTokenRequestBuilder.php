<?php


namespace Tokenio;


use Io\Token\Proto\Common\Token\TokenRequestPayload;

class AccessTokenRequestBuilder extends TokenRequestBuilder
{
    public function __construct($resources)
    {
        parent::__construct(null);
        $accessBody = new TokenRequestPayload\AccessBody();
        $accessBody->setType($resources);
        $accessBody->setResourceTypes($resources);
        $this->requestPayload->setAccessBody($accessBody);
    }
}