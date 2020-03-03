<?php

namespace Tokenio;

use Io\Token\Proto\Common\Security\Key;

class DeviceInfo
{
    private $memberId;
    private $keyList;

    /**
     * Creates an instance.
     *
     * @param string memberId member id
     * @param Key[] $keyList list of keys
     */
    function __construct($memberId, $keyList)
    {
        $this->memberId = $memberId;
        $this->keyList = $keyList;
    }

    /**
     * Gets member ID.
     *
     * @return member ID
     */
    function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Gets device keys.
     *
     * @return Key[] of device keys
     */
    function getKeys()
    {
        return $this->keyList;
    }
}