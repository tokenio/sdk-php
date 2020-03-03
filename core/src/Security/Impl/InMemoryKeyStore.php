<?php

namespace Tokenio\Security;

use Io\Token\Proto\Common\Security\Key\Level;
use Tokenio\Exception\IllegalArgumentException;

class InMemoryKeyStore implements KeyStoreInterface
{
    private $allKeys;

    public function __construct()
    {
        $this->allKeys = array();
    }

    /**
     * @param string $memberId
     * @param KeyPair $keyPair
     * @throws IllegalArgumentException
     */
    public function put($memberId, $keyPair)
    {
        if ($keyPair->isExpired()) {
            throw new IllegalArgumentException("Key " . $keyPair->getId());
        }

        if (!in_array(array($memberId, $keyPair->getId(), $keyPair), $this->allKeys)) {
            array_push($this->allKeys, array($memberId, $keyPair->getId(), $keyPair));
        }
    }

    /**
     * @param string $memberId
     * @param int $level
     * @return KeyPair
     * @throws IllegalArgumentException
     */
    public function getByLevel($memberId, $level)
    {
        $keys = array();
        foreach ($this->allKeys as $key) {
            if ($key[0] == $memberId) {
                array_push($keys, $key);
            }
        }
        foreach ($keys as $key) {
            if ($key[2]->getLevel() == $level && !$key[2]->isExpired()) {
                return $key[2];
            }
        }
        throw new IllegalArgumentException("Key not found for level: " . $level);
    }

    /**
     * @param string $memberId
     * @param string $keyId
     * @return mixed
     * @throws IllegalArgumentException
     */
    public function getById($memberId, $keyId)
    {
        foreach ($this->allKeys as $keys) {
            if ($keys[0] == $memberId && $keys[1] == $keyId && !$keys[2]->isExpired()) {
                if (!$keys[2]->isExpired()) {
                    return $keys[2];
                }
                throw new IllegalArgumentException("Key with id: " . $keyId);
            }
        }
        throw new IllegalArgumentException("Key not found for id: " . $keyId);
    }

    /**
     * @param $memberId
     * @return array
     */
    public function keyList($memberId)
    {
        $keyList = array();
        foreach ($this->allKeys as $key) {
            if ($key[0] == $memberId) {
                if (!$key[2]->isExpired()) {
                    array_push($keyList, $key);
                }
            }
        }
        return $keyList;
    }

    /**
     * Deletes keys for a specific member.
     *
     * @param string $memberId
     */
    public function deleteKeys($memberId)
    {
        $keys = array_keys(array_column($this->allKeys, 0), $memberId);
        foreach ($keys as $key) {
            unset($this->allKeys[$key]);
        }
    }
}