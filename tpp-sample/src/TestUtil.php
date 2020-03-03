<?php

namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Alias\Alias;
use Tokenio\TokenCluster;
use Tokenio\TokenEnvironment;
use Tokenio\Tpp\TokenClient;
use Tokenio\Tpp\Util\Util;
use Tokenio\User\Member;
use Tokenio\Util\Strings;

class TestUtil
{
    const DEV_KEY = "f3982819-5d8d-4123-9601-886df2780f42";
    const TOKEN_REALM = "token";

    private function __construct()
    {
    }

    /**
     * Create a TokenIO SDK client handy for testing samples.
     *
     * @return TokenClient
     * @throws \Exception
     */
    public static function createClient() {
        return TokenClient::create(TokenCluster::get(TokenEnvironment::DEVELOPMENT), self::DEV_KEY);
    }

    /**
     * Generates random user name to be used for testing.
     *
     * @return Alias
     */
    public static function randomAlias() {
        $alias = new Alias();
        $alias->setType(Alias\Type::EMAIL)
            ->setRealm(self::TOKEN_REALM)
            ->setValue("alias-".strtolower(Strings::generateNonce())."+noverify@example.com");
        return $alias;
    }

    /**
     * @return Member
     * @throws \Exception
     */
    public static function createUserMember()
    {
        $client = \Tokenio\User\TokenClient::create(TokenCluster::get(TokenEnvironment::DEVELOPMENT), self::DEV_KEY);
        $alias = self::randomAlias();
        $member = $client->createMember($alias);
        $member->createTestBankAccount(1000.0, "EUR");
        return $member;
    }
}