<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Member\ProfilePictureSize;
use PHPUnit\Framework\TestCase;
use Tokenio\Member;
use Tokenio\Util\TestUtil;

class ProfileTest extends TestCase
{
    /** @var \Tokenio\TokenIO */
    protected $tokenIO;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenIO = TestUtil::initializeSDK();
        $this->member = $this->tokenIO->createMember(TestUtil::generateAlias());
    }

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

    public function testGetNoProfilePicture()
    {
        $blob = $this->member->getProfilePicture($this->member->getMemberId(), ProfilePictureSize::ORIGINAL);
        $this->assertEquals('', $blob->getId());
    }
}