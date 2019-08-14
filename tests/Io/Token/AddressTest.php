<?php

namespace Test\Io\Token;

use Io\Token\Proto\Common\Member\AddressRecord;
use PHPUnit\Framework\TestCase;
use Io\Token\Member;
use Io\Token\Util\Strings;

class AddressTest extends TestCase
{
    /** @var \Io\Token\TokenClient */
    protected $tokenIO;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member = $this->tokenIO->createMember(TestUtil::generateAlias());
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }

    public function testAddAddress()
    {
        $name = Strings::generateNonce();
        $payload = TestUtil::generateAddress();
        $address = $this->member->addAddress($name, $payload);
        $this->assertEquals($name, $address->getName());
        $this->assertEquals($payload, $address->getAddress());
    }

    public function testAddAndGetAddress()
    {
        $name = Strings::generateNonce();
        $payload = TestUtil::generateAddress();
        $address = $this->member->addAddress($name, $payload);
        $result = $this->member->getAddress($address->getId());
        $this->assertEquals($address, $result);
    }

    public function testCreateAndGetAddresses()
    {
        $addressMap = [Strings::generateNonce() => TestUtil::generateAddress(),
                       Strings::generateNonce() => TestUtil::generateAddress(),
                       Strings::generateNonce() => TestUtil::generateAddress()];

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
        $this->expectException('Io\Token\Exception\StatusRuntimeException');
        $nonExistingAddress = $this->member->getAddress($fakeAddressId . 'adadasss');
        $this->assertEmpty($nonExistingAddress);
    }

    public function testDeleteAddress()
    {
        $member = $this->tokenIO->createMember();

        $name = Strings::generateNonce();
        $payload = TestUtil::generateAddress();
        $address = $member->addAddress($name, $payload);

        $member->getAddress($address->getId());
        $this->assertNotEmpty($member->getAddresses());

        $member->deleteAddress($address->getId());
        $this->assertEmpty($member->getAddresses());
    }
}