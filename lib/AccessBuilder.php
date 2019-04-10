<?php


namespace Tokenio;


use Io\Token\Proto\Common\Token\TokenRequestPayload;

class AccessBuilder extends TokenRequestBuilder
{
    public function __construct(...$resources)
    {
        $accessBody = new TokenRequestPayload\AccessBody();
        $accessBody->setType($resources);
        $this->requestPayload->setAccessBody($accessBody);
    }
}