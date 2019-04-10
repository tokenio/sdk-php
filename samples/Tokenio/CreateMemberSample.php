<?php


namespace Sample\Tokenio;


use Io\Token\Proto\Common\Alias\Alias;
use Symfony\Component\Filesystem\Exception\IOException;
use Tokenio\Member;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
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
        try{
            $keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/');
            $builder = new TokenClientBuilder();
            $builder->connectTo(TokenCluster::get(TokenEnvironment::SANDBOX));
            $builder->withKeyStore($keyStore);

            $tokenClient = $builder->build();

            $alias = new Alias();
            $alias->setType(Alias\Type::EMAIL);
            $email = 'asphp-' . strtolower(Strings::generateNonce()) . '+noverify@example.com';
            $alias->setValue($email);

            $member = $tokenClient->createMember($alias);
            // let user recover member by verifying email if they lose keys
            $member->useDefaultRecoveryRule();

            return $member;

        }catch (IOException $exception){
            throw new \RuntimeException($exception);
        }
    }
}