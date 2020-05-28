<?php

namespace Test\Tokenio;

use Io\Token\Samples\WebhookSample;
use PHPUnit\Framework\TestCase;
use Tokenio\Member;

class WebhookSampleTest extends TestCase
{
    /** @var \Tokenio\TokenClient */
    protected $tokenClient;
    /** @var Member $member */
    private $member;

    protected function setUp()
    {
        $this->tokenClient = TestUtil::initializeSDK();
        $this->member = $this->tokenClient->createMember(TestUtil::generateAlias());
    }

    protected function tearDown()
    {
        parent::tearDown();
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }

    public function testWebhook()
    {
        $this->assertTrue(WebhookSample::setWebhookConfig($this->member));

        $config = WebhookSample::getWebhookConfig($this->member);
        $this->assertNotEmpty($config->getUrl());
        $this->assertNotEmpty($config->getType());

        $this->assertTrue(WebhookSample::deleteWebhookConfig($this->member));
        $this->expectException('Tokenio\Exception\StatusRuntimeException');
        $config = WebhookSample::getWebhookConfig($this->member);
    }

    public function testWebhook_notFound() {
            $this->expectException('Tokenio\Exception\StatusRuntimeException');
            $config = WebhookSample::getWebhookConfig($this->member);
    }
}
