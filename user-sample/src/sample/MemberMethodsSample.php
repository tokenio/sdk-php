<?php


namespace Tokenio\Sample\User;


use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Security\Key\Level;
use Io\Token\Proto\Common\Token\TokenMember;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\User\Member;
use Tokenio\User\TokenClient;
use Tokenio\Util\Strings;

class MemberMethodsSample
{
    /**
     * Add or removes alias
     *
     * @param $tokenClient TokenClient
     * @param $member Member
     * @return TokenMember
     * @throws \Tokenio\Exception\InvalidRealmException
     * @throws \Exception
     */
    public static function aliases($tokenClient, $member)
    {
        $alias1 = $member->firstAlias();
        $alias2 = new Alias();
        $alias2->setType(Alias\Type::EMAIL)->setValue("alias2-".Strings::generateNonce()."+noverify@token.io");
        $member->addAlias($alias2);

        $alias3 = new Alias();
        $alias3->setType(Alias\Type::EMAIL)->setValue("alias3-".Strings::generateNonce()."+noverify@token.io");

        $alias4 = new Alias();
        $alias4->setType(Alias\Type::EMAIL)->setValue("alias4-".Strings::generateNonce()."+noverify@token.io");
        $member->addAliases(array($alias3, $alias4));
        $member->removeAlias($alias1);

        $member->removeAliases(array($alias2, $alias3));

        $resolved = $tokenClient->resolveAlias($alias4);
        return $resolved;
    }


    /**
     * Adds and removes keys.
     *
     * @param $crypto TokenCryptoEngine
     * @param $member Member
     * @throws \Tokenio\Exception\CryptographicException
     * @throws \Exception
     */
    public static function keys($crypto, $member)
    {
        $lowKey = $crypto->generateKey(Level::LOW);
        $member->approveKey($lowKey);

        $standardKey = $crypto->generateKey(Level::STANDARD);
        $privilegedKey = $crypto->generateKey(Level::PRIVILEGED);

        $keys = array();
        $keys[] = $standardKey;
        $keys[] = $privilegedKey;

        $member->approveKeys($keys);

        $member->removeKey($lowKey->getId());
    }

    /**
     * @param $member Member
     * @return \Io\Token\Proto\Common\Member\Profile
     * @throws \Exception
     */
    public static function profiles($member)
    {
        $picture = base64_decode("/9j/4AAQSkZJRgABAQEASABIAAD//gATQ3JlYXRlZCB3aXRoIEdJTVD/2wBDA"
            . "BALDA4MChAODQ4SERATGCgaGBYWGDEjJR0oOjM9PDkzODdASFxOQERXRT"
            . "c4UG1RV19iZ2hnPk1xeXBkeFxlZ2P/2wBDARESEhgVGC8aGi9jQjhCY2N"
            . "jY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2Nj"
            . "Y2NjY2P/wgARCAAIAAgDAREAAhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAA"
            . "AAABv/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhADEAAAAT5//8"
            . "QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABBQJ//8QAFBEBAAAAAAA"
            . "AAAAAAAAAAAAAAP/aAAgBAwEBPwF//8QAFBEBAAAAAAAAAAAAAAAAAAAA"
            . "AP/aAAgBAgEBPwF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQAGP"
            . "wJ//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPyF//9oADAMBAA"
            . "IAAwAAABAf/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAwEBPxB//8Q"
            . "AFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAgEBPxB//8QAFBABAAAAAAAA"
            . "AAAAAAAAAAAAAP/aAAgBAQABPxB//9k=");

        $name = new Profile();
        $name->setDisplayNameFirst("Tycho");
        $name->setDisplayNameLast("Nestoris");

        $member->setProfile($name);
        $member->setProfilePicture("image/jpeg", $picture);

        return $member->getProfile($member->getMemberId());
    }


}