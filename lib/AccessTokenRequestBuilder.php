<?php


namespace Tokenio;


use Io\Token\Proto\Common\Token\TokenRequestPayload;
use Tokenio\Util\Util;

class AccessTokenRequestBuilder extends TokenRequestBuilder
{
    public function __construct($resources)
    {
        parent::__construct(null);
        $enumMap = Util::reflectEnum("Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody\ResourceType");

        $accessBody = new TokenRequestPayload\AccessBody();
        $accessBody->setResourceTypes($this->filterEnums($enumMap, $resources));
        $this->requestPayload->setAccessBody($accessBody);
    }

    private function filterEnums($from, $values){
        $result = array();
        foreach($values as $val){
            $result[] = $from[$val];
        }
        return $result;
    }
}