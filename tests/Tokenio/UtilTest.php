<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Token\AccessBody;
use Io\Token\Proto\Common\Token\TokenMember;
use Io\Token\Proto\Common\Token\TokenPayload;
use PHPUnit\Framework\TestCase;
use Tokenio\Util\Base58;
use Tokenio\Util\Util;

class UtilTest extends TestCase
{

    public function testJsonSerializer()
    {
        $tokenMember = new TokenMember();
        $tokenMember->setId('memberId');

        $resource = new AccessBody\Resource();
        $resource->setAllAddresses(new AccessBody\Resource\AllAddresses());

        $access = new AccessBody();
        $access->setResources([$resource]);

        $payload = new TokenPayload();
        $payload->setTo($tokenMember)
            ->setAccess($access)
            ->setRefId('refId');

        $expected = "{\"access\":{\"resources\":[{\"allAddresses\":{}}]},\"refId\":\"refId\",\"to\":{\"id\":\"memberId\"}}";
        $this->assertEquals($expected, Util::toJson($payload));

    }

    public function testHashAlias()
    {
        $alias = new Alias();
        $alias->setType(Alias\Type::EMAIL)
            ->setValue('bob@token.io');

        $this->assertEquals('HHzc3XVck27qD2gadGVzjffaBZrU8ZLEd2jmtcyPKeev', Util::hashAlias($alias));
    }

    public function testBase58Hashing()
    {
        $result = Base58::encode('bob@token.io');
        $this->assertEquals('2rjpGWoxbc8ASyDVx', $result);
    }


}