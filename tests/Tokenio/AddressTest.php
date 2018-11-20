<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Member\AddressRecord;
use Tokenio\Util\Strings;

class AddressTest extends TokenBaseTest
{
    public function testAddAddress()
    {
        $name = Strings::generateNonce();
        $payload = self::generateAddress();
        $address = $this->member->addAddress($name, $payload);
        $this->assertEquals($name, $address->getName());
        $this->assertEquals($payload, $address->getAddress());
    }

    public function testAddAndGetAddress()
    {
        $name = Strings::generateNonce();
        $payload = self::generateAddress();
        $address = $this->member->addAddress($name, $payload);
        $result = $this->member->getAddress($address->getId());
        $this->assertEquals($address, $result);
    }

    public function testCreateAndGetAddresses()
    {
        $addressMap = [Strings::generateNonce() => self::generateAddress(),
                       Strings::generateNonce() => self::generateAddress(),
                       Strings::generateNonce() => self::generateAddress()];

        foreach ($addressMap as $k => $v){
            $this->member->addAddress($k, $v);
        }
        $actual = array();
        /** @var AddressRecord $addressRecord */
        foreach ($this->member->getAddresses() as $addressRecord){
            $actual[$addressRecord->getName()] = $addressRecord->getAddress();
        }
        $this->assertEquals($addressMap, $actual);
    }

    public function testGetAddresses_NotFound()
    {
        $member = $this->tokenIO->createMember();
        $this->assertEmpty($member->getAddresses());
    }

    public function testGetAddress_NotFound()
    {
        $fakeAddressId = Strings::generateNonce();

    }
    /*

        [Test]
        public void GetAddress_NotFound()
        {
            var fakeAddressId = Util.Nonce();
            Assert.Throws<AggregateException>(() => member.GetAddress(fakeAddressId));
        }

        [Test]
        public void DeleteAddress()
        {
            var name = Util.Nonce();
            var payload = Address();
            var address = member.AddAddress(name, payload);

            member.GetAddress(address.Id);
            Assert.IsNotEmpty(member.GetAddresses());

            member.DeleteAddress(address.Id);
            Assert.IsEmpty(member.GetAddresses());
        }
    } */
}