<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Blob\Blob\Payload;
use Tokenio\Util\Strings;
use Tokenio\Util\Util;

class BlobTest extends TokenBaseTest
{
    const FILENAME = 'file.json';
    const FILETYPE = 'application/json';

    public function testCheckHash()
    {
        $randomData = Strings::generateRandomString(100);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $blobPayload = new Payload();
        $blobPayload->setData($randomData)
                    ->setName(self::FILENAME)
                    ->setType(self::FILETYPE)
                    ->setOwnerId($this->member->getMemberId());

        $hash = Util::hashString($blobPayload->serializeToJsonString());
        $this->assertContains($hash, $attachment->getBlobId());
    }

    public function testCreate()
    {
        $randomData = Strings::generateRandomString(100);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $this->assertEquals(self::FILETYPE, $attachment->getType());
        $this->assertEquals(self::FILENAME, $attachment->getName());
        $this->assertGreaterThan(5, count_chars($attachment->getBlobId()));
    }

    public function testCreateIdempotent()
    {
        $randomData = Strings::generateRandomString(100);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $attachment2 = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $this->assertEquals($attachment, $attachment2);
    }

    public function testGet()
    {
        $randomData = Strings::generateRandomString(100);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);

        $blob = $this->member->getBlob($attachment->getBlobId());
        $this->assertEquals($attachment->getBlobId(), $blob->getId());
        $this->assertEquals($randomData, $blob->getPayload()->getData());
        $this->assertEquals($this->member->getMemberId(), $blob->getPayload()->getOwnerId());
    }

    public function testEmptyData()
    {
        $randomData = Strings::generateRandomString(0);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $blob = $this->member->getBlob($attachment->getBlobId());

        $this->assertEquals($attachment->getBlobId(), $blob->getId());
        $this->assertEquals($randomData, $blob->getPayload()->getData());
        $this->assertEquals($this->member->getMemberId(), $blob->getPayload()->getOwnerId());
    }

    public function testMediumSize()
    {
        $randomData = Strings::generateRandomString(5000);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);
        $blob = $this->member->getBlob($attachment->getBlobId());

        $this->assertEquals($attachment->getBlobId(), $blob->getId());
        $this->assertEquals($randomData, $blob->getPayload()->getData());
        $this->assertEquals($this->member->getMemberId(), $blob->getPayload()->getOwnerId());
    }

    public function testPublicAccess()
    {
        $randomData = Strings::generateRandomString(50);
        $attachment = $this->member->createBlob($this->member->getMemberId(), self::FILETYPE, self::FILENAME, $randomData);

        $otherMember = $this->tokenIO->createMember();
        $blob1 = $this->member->getBlob($attachment->getBlobId());
        $blob2 = $otherMember->getBlob($attachment->getBlobId());

        $this->assertEquals($blob1, $blob2);
    }
}