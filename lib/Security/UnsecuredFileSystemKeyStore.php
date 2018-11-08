<?php

namespace Tokenio\Security;

use Tokenio\Exception\InvalidUnsecuredFileSystemKeyStoreConfiguration;

class UnsecuredFileSystemKeyStore implements KeyStoreInterface
{
    const DEFAULT_DIRECTORY_MODE = 0777;

    private $directory;
    private $keys;

    /**
     * Construct the UnsecuredFileSystemKeyStore.
     *
     * @param string $directory the directory to store keys
     */
    public function __construct($directory)
    {
        if (!$this->createDirectory($directory)) {
            throw new InvalidUnsecuredFileSystemKeyStoreConfiguration("Invalid directory: " . $directory);
        }

        $this->directory = $directory;
        $this->keys = array();

        $files = $this->getFiles();
        foreach ($files as $file) {
            $filePath = $directory . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath)) {
                $this->loadFromFile($filePath);
            }
        }
    }

    private function createDirectory($directory)
    {
        if (!$directory) {
            return false;
        }

        if (file_exists($directory) && is_dir($directory)) {
            if (is_writable($directory)) {
                return true;
            }

            return chmod($directory, self::DEFAULT_DIRECTORY_MODE);
        }

        return mkdir($directory, self::DEFAULT_DIRECTORY_MODE, true);
    }

    private function getFiles()
    {
        return array_diff(scandir($this->directory), array('.', '..'));
    }

    private function loadFromFile($file)
    {
        $memberId = str_replace('_', ':', basename($file));
        $this->keys[$memberId] = array();

        $memberKeys = json_decode(file_get_contents($file), true);
        if ($memberKeys == null) {
            return;
        }

        foreach ($memberKeys as $key) {
            array_push($this->keys[$memberId], KeyPair::fromJson($key));
        }
    }

    /**
     * Puts a specified key pair into the storage.
     *
     * @param string $memberId the member id
     * @param KeyPair $keyPair the key pair
     * @return void
     */
    public function put($memberId, $keyPair)
    {
        $file = $this->directory . DIRECTORY_SEPARATOR . str_replace(':', '_', $memberId);

        if (array_key_exists($memberId, $this->keys)) {
            array_push($this->keys[$memberId], $keyPair);
        } else {
            $this->keys[$memberId] = array();
            array_push($this->keys[$memberId], $keyPair);
        }

        file_put_contents($file, json_encode($this->keys[$memberId]));
    }

    /**
     * Gets a key pair of a specific level.
     *
     * @param string $memberId the member id
     * @param int $level the level of the key pair
     * @return KeyPair the key pair
     */
    public function getByLevel($memberId, $level)
    {
        $keys = array_reverse($this->keys[$memberId]);

        /** @var KeyPair $key */
        foreach ($keys as $key) {
            if ($key->getLevel() == $level) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Gets a key pair of by its ID.
     *
     * @param string $memberId the member id
     * @param string $keyId he key id
     * @return KeyPair the key pair
     */
    public function getById($memberId, $keyId)
    {
        $keys = $this->keys[$memberId];

        foreach ($keys as $key) {
            /** @var KeyPair $key */
            if ($key->getId() == $keyId) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Get all of a member's keys.
     *
     * @param string $memberId the member id
     * @return array a list of key pairs
     */
    public function keyList($memberId)
    {
        return $this->keys[$memberId];
    }

    /**
     * @return null|string
     */
    public function getFirstMemberId()
    {
        if (empty($this->keys)) {
            return null;
        }

        reset($this->keys);
        return key($this->keys);
    }
}