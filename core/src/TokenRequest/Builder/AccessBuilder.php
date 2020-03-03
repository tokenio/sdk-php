<?php


namespace Tokenio\TokenRequest\Builder;

use Io\Token\Proto\Common\Token\TokenRequestPayload;
use ReflectionException;
use Tokenio\Util\Util;

class AccessBuilder extends TokenRequestBuilder
{
    /**
     * AccessTokenRequestBuilder constructor.
     * @param int[] $resources
     * @param TokenRequestPayload\AccessBody\AccountResourceList $list
     * @throws ReflectionException
     */
    public function __construct($resources, $list)
    {
        parent::__construct();

        if ($list != null) {
            $accessBody = new TokenRequestPayload\AccessBody();
            $accessBody->setAccountResourceList($list);
            $this->requestPayload->setAccessBody($accessBody);
        } else {
            $enumMap = Util::reflectEnum("Io\Token\Proto\Common\Token\TokenRequestPayload\AccessBody\ResourceType");
            $resourceTypes = new TokenRequestPayload\AccessBody\ResourceTypeList();
            $resourceTypes->setResources($resources);
            $accessBody = new TokenRequestPayload\AccessBody();
            $accessBody->setResourceTypeList($resourceTypes)->setType($resources);
            $this->requestPayload->setAccessBody($accessBody);
        }
    }

    private function filterEnums($from, $values)
    {
        $result = array();
        foreach ($values as $val) {
            $result[] = $from[$val];
        }
        return $result;
    }
}
