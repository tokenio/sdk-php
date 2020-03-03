<?php


namespace Tokenio\Sample\Tpp;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Profile;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Token\TokenMember;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\TokenClient;
use Tokenio\Tpp\Member;

class MemberMethodsSample
{
    /**
     * Add or removes alias
     *
     * @param $member Member
     * @throws \Tokenio\Exception\InvalidRealmException
     * @throws \Exception
     */
    public static function aliases($member)
    {
        $alias = new Alias();
        $alias->setType(Alias\Type::DOMAIN)
            ->setValue("verified-domain.com");

        $member->addAlias($alias);
        $member->removeAlias($alias);
    }

    /**
     * Resolves a user's alias.
     *
     * @param $client TokenClient
     */
    public static function resolveAlias($client)
    {
        $alias = new Alias();
        $alias->setValue("user-email@example.com");

        /**@var $resolved TokenMember **/
        $resolved = $client->resolveAlias($alias);
        $memberId = $resolved->getId();
        $resolvedAlias = $resolved->getAlias();
    }

    /**
     * Adds and removes keys.
     *
     * @param $crypto TokenCryptoEngine
     * @param $member Member
     *
     * @throws \Tokenio\Exception\CryptographicException
     * @throws \Exception
     */
    public static function keys($crypto, $member)
    {
        $lowKey = $crypto->generateKey(Key\Level::LOW);
        $member->approveKey($lowKey);

        $standardKey = $crypto->generateKey(Key\Level::STANDARD);
        $privilegedKey = $crypto->generateKey(Key\Level::PRIVILEGED);

        $keys = array();
        $keys[] = $standardKey;
        $keys[] = $privilegedKey;

        $member->approveKeys($keys);

        $member->removeKey($lowKey->getId());
    }

    /**
     * @param $member Member
     * @return Profile
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