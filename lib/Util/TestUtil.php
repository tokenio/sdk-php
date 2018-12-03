<?php

namespace Tokenio\Util;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Address\Address;
use Io\Token\Proto\Common\Alias\Alias;
use Tokenio\Config\TokenCluster;
use Tokenio\Config\TokenEnvironment;
use Tokenio\Config\TokenIoBuilder;
use Tokenio\Security\UnsecuredFileSystemKeyStore;

abstract class TestUtil
{
    const DEVELOPER_KEY = '4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI';

    public static function initializeSDK()
    {
        $keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . 'tests/Tokenio/test-keys/');

        $builder = new TokenIoBuilder();
        $builder->connectTo(TokenCluster::get(TokenEnvironment::SANDBOX));
        $builder->developerKey(self::DEVELOPER_KEY);
        $builder->withKeyStore($keyStore);
        return $builder->build();
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

    /**
     * Looks up a list of existing transfers.
     *
     * @param RepeatedField $repeated
     * @return array
     */
    public static function repeatedFieldsToArray($repeated)
    {
        $result = array();
        foreach ($repeated as $item) {
            $result[] = $item;
        }
        return $result;
    }
}