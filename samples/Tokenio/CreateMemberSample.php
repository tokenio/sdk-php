<?php


namespace Sample\Tokenio;


use http\Exception\RuntimeException;
use Io\Token\Proto\Common\Alias\Alias;
use Symfony\Component\Filesystem\Exception\IOException;
use Tokenio\Member;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\TokenClient;
use Tokenio\TokenClientBuilder;
use Tokenio\TokenCluster;
use Tokenio\TokenEnvironment;
use Tokenio\Util\Strings;

class CreateMemberSample
{
    /**
     * Creates and returns a new token member
     *
     * @return Member
     */
    public static function createMember()
    {
        // Create the client, which communicates with
        // the Token cloud
        try{
            $keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/');
            $builder = new TokenClientBuilder();
            $builder->connectTo(TokenCluster::get(TokenEnvironment::SANDBOX));
            $builder->withKeyStore($keyStore);

            $tokenClient = $builder->build();

            // An alias is a "human-readable" reference to a member.
            // Here, we use a random email. This works in test environments.
            // but in production, TokenOS would try to verify we own the address,
            // so a random address wouldn't be useful for much.
            // We use a random address because otherwise, if we ran a second
            // time, Token would say the alias was already taken.
            $alias = new Alias();
            $alias->setType(Alias\Type::EMAIL);
            $email = 'asphp-' . strtolower(Strings::generateNonce()) . '+noverify@example.com';
            $alias->setValue($email);

            $member = $tokenClient->createMember($alias);
            // let user recover member by verifying email if they lose keys
            $member->useDefaultRecoveryRule();

            return $member;

        }catch (IOException $exception){
            throw new RuntimeException($exception);
        }
    }
}