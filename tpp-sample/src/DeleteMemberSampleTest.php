<?php


namespace Tokenio\Sample\Tpp;


use PHPUnit\Framework\TestCase;
use Tokenio\Exception\StatusRuntimeException;

class DeleteMemberSampleTest extends TestCase
{
    public function testdeleteMember() {
         $tokenClient = TestUtil::createClient();
         $member = $tokenClient->createMember(TestUtil::randomAlias());
         $this->assertEquals($member->getMemberId(), $tokenClient->getMember($member->getMemberId())->getMemberId());

         $member->deleteMember();

         $this->expectException(StatusRuntimeException::class);

         $tokenClient->getMember($member->getMemberId());
    }
}