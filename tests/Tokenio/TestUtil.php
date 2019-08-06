<?php

namespace Test\Tokenio;

use Google\Protobuf\Internal\RepeatedField;
use Io\Token\Proto\Common\Address\Address;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\TokenClientBuilder;
use Io\Token\TokenCluster;
use Io\Token\TokenEnvironment;
use Io\Token\Security\UnsecuredFileSystemKeyStore;
use Io\Token\Util\Strings;

abstract class TestUtil
{
    const DEVELOPER_KEY = '4qY7lqQw8NOl9gng0ZHgT4xdiDqxqoGVutuZwrUYQsI';

    public static function initializeSDK()
    {
        $keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/');
        $builder = new TokenClientBuilder();
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

    public static function removeDirectory($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        self::removeDirectory($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }
}