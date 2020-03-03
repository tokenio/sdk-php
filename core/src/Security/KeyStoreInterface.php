<?php

namespace Tokenio\Security;

interface KeyStoreInterface
{
    /**
     * Puts a specified key pair into the storage.
     *
     * @param string $memberId the member id
     * @param KeyPair $keyPair the key pair
     * @return void
     */
    public function put($memberId, $keyPair);

    /**
     * Gets a key pair of a specific level.
     *
     * @param string $memberId the member id
     * @param int $level the level of the key pair
     * @return KeyPair the key pair
     */
    public function getByLevel($memberId, $level);

    /**
     * Gets a key pair of by its ID.
     *
     * @param string $memberId the member id
     * @param string $keyId he key id
     * @return KeyPair the key pair
     */
    public function getById($memberId, $keyId);

    /**
     * Get all of a member's keys.
     *
     * @param string $memberId the member id
     * @return array a list of key pairs
     */
    public function keyList($memberId);

    /**
     * Deletes keys for a specific member.
     *
     * @param string $memberId
     * @return array without those memberId
     */
    public function deleteKeys($memberId);
}
