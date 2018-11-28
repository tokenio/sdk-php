<?php

namespace Test\Tokenio;

require_once 'TokenBaseTest.php';
use Io\Token\Proto\Common\Member\TrustedBeneficiary;
use Tokenio\Member;

class TrustedBenificiaryTest extends TokenBaseTest
{

    /** @var Member $member1 */
    private $member1;
    /** @var Member $member2 */
    private $member2;
    /** @var Member $member3 */
    private $member3;

    protected function setUp()
    {
        parent::setUp();
        $this->member1 = $this->tokenIO->createMember(self::generateAlias());
        $this->member2 = $this->tokenIO->createMember(self::generateAlias());
        $this->member3 = $this->tokenIO->createMember(self::generateAlias());
    }

    public function testAddAndGetTrustedBeneficiary()
    {
        $this->member1->addTrustedBeneficiary($this->member2->getMemberId());
        $beneficiaries = $this->member1->getTrustedBeneficiaries();
        $beneficiaryIds = array();
        /** @var TrustedBeneficiary $beneficiary */
        foreach($beneficiaries as $beneficiary){
            $beneficiaryIds[] = $beneficiary->getPayload()->getMemberId();
        }
        $this->assertEquals([$this->member2->getMemberId()], $beneficiaryIds);


        $this->member1->addTrustedBeneficiary($this->member3->getMemberId());
        $beneficiaries = $this->member1->getTrustedBeneficiaries();
        $beneficiaryIds = array();
        /** @var TrustedBeneficiary $beneficiary */
        foreach($beneficiaries as $beneficiary){
            $beneficiaryIds[] = $beneficiary->getPayload()->getMemberId();
        }
        $this->assertEquals([$this->member2->getMemberId(), $this->member3->getMemberId()], $beneficiaryIds);
    }

    public function testRemoveTrustedBeneficiary()
    {
        $this->member2->addTrustedBeneficiary($this->member1->getMemberId());
        $this->member2->addTrustedBeneficiary($this->member3->getMemberId());

        $beneficiaries = $this->member2->getTrustedBeneficiaries();
        $beneficiaryIds = array();
        /** @var TrustedBeneficiary $beneficiary */
        foreach($beneficiaries as $beneficiary){
            $beneficiaryIds[] = $beneficiary->getPayload()->getMemberId();
        }
        $this->assertEquals([$this->member1->getMemberId(), $this->member3->getMemberId()], $beneficiaryIds);

        $this->member2->removeTrustedBeneficiary($this->member3->getMemberId());
        $beneficiaries = $this->member2->getTrustedBeneficiaries();
        $beneficiaryIds = array();
        /** @var TrustedBeneficiary $beneficiary */
        foreach($beneficiaries as $beneficiary){
            $beneficiaryIds[] = $beneficiary->getPayload()->getMemberId();
        }
        $this->assertEquals([$this->member1->getMemberId()], $beneficiaryIds);
        $this->member2->removeTrustedBeneficiary($this->member1->getMemberId());
        $this->assertEmpty($this->member2->getTrustedBeneficiaries());
    }
}