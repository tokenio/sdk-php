<?php

namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Notification\DeviceMetadata;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Key\Level;
use Tokenio\User\TokenClient;

class ProvisionDeviceSample
{
    /**
     * @param $tokenClient TokenClient
     * @param $alias Alias
     */
    public static function provisionDevice($tokenClient, $alias)
    {
        $deviceInfo = $tokenClient->provisionDevice($alias);
        $lowkeys = $deviceInfo->getKeys();

        /* @var $lowKey Key */
        $lowKey = null;
        foreach ($lowkeys as $key)
        {
            if($key->getLevel() === Level::LOW)
            {
                $lowKey = $key;
            }
            else{
                $lowKey = null;
            }
        }

        $deviceMetadata = new DeviceMetadata();
        $deviceMetadata->setApplication("SDk Sample");

        $status = $tokenClient->notifyAddKey($alias, array($lowKey), $deviceMetadata);
        return $lowKey;
    }

    /**
     * @param $tokenClient TokenClient
     * @param $alias Alias
     * @return \Tokenio\User\Member
     */
    public static function useProvisionedDevice($tokenClient , $alias)
    {
        $memberId = $tokenClient->getMemberId($alias);
        $member = $tokenClient->getMember($memberId);
        return $member;
    }
}