<?php

namespace Test\Tokenio;

use Io\Token\Proto\Common\Address\Address;
use PHPUnit\Framework\TestCase;
use Tokenio\Config\TokenCluster;
use Tokenio\Config\TokenEnvironment;
use Tokenio\Config\TokenIoBuilder;
use Tokenio\Util\Strings;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Io\Token\Proto\Common\Alias\Alias;

abstract class TokenBaseTest extends TestCase
{
    const DEVELOPER_KEY = '4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI';

    /**
     * @var UnsecuredFileSystemKeyStore
    */
    protected $keyStore;
    /**
     * @var \Tokenio\Security\CryptoEngineInterface
     */
    private $cryptoEngine;

    /**
     * @var \Tokenio\TokenIO
     */
    protected $tokenIO;

    /**
     * @var \Tokenio\Member
     */
    protected $member;

    protected function setUp()
    {
        $this->tokenIO = $this->initializeSDK();
    }

    protected function initializeSDK()
    {
        $this->keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/');

        $builder = new TokenIoBuilder();
        $builder->connectTo(TokenCluster::get(TokenEnvironment::SANDBOX));
        $builder->developerKey(self::DEVELOPER_KEY);
        $builder->withKeyStore($this->keyStore);
        return $builder->build();
    }

    protected function initializeMember()
    {
        $memberId = $this->keyStore->getFirstMemberId();
        if (!empty($memberId)) {
            return $this->loadMember($memberId);
        } else {
            return $this->createMember();
        }
    }

    private function loadMember($memberId)
    {
        return $this->tokenIO->getMember($memberId);
    }

    private function createMember()
    {
        return $this->tokenIO->createBusinessMember(self::generateAlias());
    }

    public static function generateAlias()
    {
        $email = 'asphp-' . strtolower(Strings::generateNonce()) . '+noverify@example.com';

        $alias = new Alias();
        $alias->setType(Alias\Type::EMAIL);
        $alias->setValue($email);

        return $alias;
    }

    public static function generateAddress()
    {
        $address = new Address();
        $address->setHouseNumber('425')
                ->setStreet('Broadway')
                ->setCity('Redwood City')
                ->setPostCode('94063')
                ->setCountry('US');

        return $address;
    }
}