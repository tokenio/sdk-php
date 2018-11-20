<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\ProfilePictureSize;

class ProfileTest extends TokenBaseTest
{
    public function testSetProfile()
    {
        $inProfile = new Profile();
        $inProfile->setDisplayNameFirst('Tomás')
                  ->setDisplayNameLast('de Aquino');

        $backProfile = $this->member->setProfile($inProfile);
        $outProfile = $this->member->getProfile($this->member->getMemberId());
        $this->assertEquals($inProfile, $backProfile);
        $this->assertEquals($backProfile, $outProfile);
    }

    public function testUpdateProfile()
    {
        $firstProfile = new Profile();
        $firstProfile->setDisplayNameFirst('Katy')
                     ->setDisplayNameLast('Hudson');

        $backProfile = $this->member->setProfile($firstProfile);
        $outProfile = $this->member->getProfile($this->member->getMemberId());
        $this->assertEquals($backProfile, $outProfile);

        $secondProfile = new Profile();
        $secondProfile->setDisplayNameFirst('Katy');
        $backProfile = $this->member->setProfile($secondProfile);
        $outProfile = $this->member->getProfile($this->member->getMemberId());
        $this->assertEquals($backProfile, $outProfile);
    }

    public function testReadProfile_notYours()
    {
        $inProfile = new Profile();
        $inProfile->setDisplayNameFirst('Tomás')
                  ->setDisplayNameLast('de Aquino');

        $this->member->setProfile($inProfile);

        $otherMember = $this->tokenIO->createMember();
        $outProfile = $otherMember->getProfile($this->member->getMemberId());
        $this->assertEquals($inProfile, $outProfile);
    }

    public function testGetProfilePicture()
    {
        // "The tiniest gif ever" , a 1x1 gif
        // http://probablyprogramming.com/2009/03/15/the-tiniest-gif-ever
        $tinyGif = 'R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        $this->member->setProfilePicture('image/gif', $tinyGif);

        $otherMember = $this->tokenIO->createMember();
        $blob = $otherMember->getProfilePicture($this->member->getMemberId(), ProfilePictureSize::ORIGINAL);
        $this->assertEquals($tinyGif, $blob->getPayload()->getData());

        // Because our example picture is so small, asking for a "small" version
        // gets us the original
        $sameBlob = $otherMember->getProfilePicture($this->member->getMemberId(), ProfilePictureSize::SMALL);
        $this->assertEquals($tinyGif, $sameBlob->getPayload()->getData());
    }

    public function testGetNoProfilePicture()
    {
        $blob = $this->member->getProfilePicture($this->member->getMemberId(), ProfilePictureSize::ORIGINAL);
        $this->assertEquals('', $blob->getId());
    }

    public function testGetPictureProfile()
    {
        // "The tiniest gif ever" , a 1x1 gif
        // http://probablyprogramming.com/2009/03/15/the-tiniest-gif-ever
        $tinyGif = 'R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        $inProfile = new Profile();
        $inProfile->setDisplayNameFirst('Tomás')
                  ->setDisplayNameLast('de Aquino');

        $otherMember = $this->tokenIO->createMember();
        $this->member->setProfile($inProfile);
        $this->member->setProfilePicture('image/gif', $tinyGif);

        $outProfile = $otherMember->getProfile($this->member->getMemberId());
        $this->assertNotEmpty($outProfile->getOriginalPictureId());
        $this->assertEquals($outProfile->getDisplayNameFirst(), $inProfile->getDisplayNameFirst());
        $this->assertEquals($outProfile->getDisplayNameLast(), $inProfile->getDisplayNameLast());

//        $blob = $otherMember->getB
        //TODO get blob
        /*
            var tinyGifString = ByteString.CopyFrom(tinyGif);
            var blob = otherMember.GetBlob(outProfile.OriginalPictureId);
            Assert.AreEqual(tinyGifString, blob.Payload.Data);
    }*/
    }


}