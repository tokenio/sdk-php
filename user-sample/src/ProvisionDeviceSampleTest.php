<?php

namespace Tokenio\Sample\User;

use PHPUnit\Framework\TestCase;

class ProvisionDeviceSampleTest extends TestCase
{
    public function testProvisionDevice()
    {
        $remoteDevice = TestUtil::createClient();
        $alias = TestUtil::randomAlias();
        $remoteMember = $remoteDevice->createMember($alias);
        $remoteMember->subscribeToNotifications("iron");
        $localDeviceClient = TestUtil::createClient();
        $key = ProvisionDeviceSample::provisionDevice($localDeviceClient, $alias);
        $remoteMember->approveKey($key);
        $local = ProvisionDeviceSample::useProvisionedDevice($localDeviceClient, $alias);
        $this->assertEquals($remoteMember->getMemberId(), $local->getMemberId());
    }
}