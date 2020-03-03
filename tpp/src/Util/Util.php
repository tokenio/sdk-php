<?php

namespace Tokenio\Tpp\Util;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Tokenio\Exception\CryptographicException;
use Tokenio\Exception\CryptoKeyNotFoundException;
use Tokenio\Security\Ed25519Verifier;
use Tokenio\Tpp\Exception\UnsupportedEncodingException;
use Tokenio\Util\Base64Url;

abstract class Util extends \Tokenio\Util\Util
{
    private function __construct()
    {
    }

    public static function getToken(){
        $alias = new Alias();
        return $alias->setType(Alias\Type::DOMAIN)
            ->setValue('token.io')
            ->setRealm('token');
    }

    /**
     * Returns map of query string parameters, given a query string.
     *
     * @param string $queryString query string
     * @return array map of parameters in query string
     */
    public static function parseQueryString($queryString){
        $params = explode("&",$queryString);
        $parameters = array();

        foreach ($params as $param){
            $name = explode("=", $param)[0];
            $value = explode("=", $param)[1];
            $parameters[$name] = $value;
        }
        return $parameters;
    }

    /**
     * URL encodes a string.
     *
     * @param string $url string to encode
     * @return string
     */
    public static function urlEncode($url){
        try {
            return urlencode($url);
        } catch (UnsupportedEncodingException $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @param string $url string to decode
     * @return string
     */
    public static function urlDecode($url){
        try {
            return urldecode($url);
        } catch (UnsupportedEncodingException $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * Verify signature for payload
     *
     * @param Member $member
     * @param TokenRequestStatePayload $payload
     * @param Signature $signature
     * @throws CryptoKeyNotFoundException
     * @throws CryptographicException
     */
    public static function verifySignature($member, $payload, $signature)
    {
        $key = self::getSigningKey($member, $signature);

        if ($key == null) {
            throw new CryptoKeyNotFoundException($signature->getKeyId());
        }

        $verifier = new Ed25519Verifier(Base64Url::decode($key->getPublicKey()));
        $verifier->verify($payload, $signature->getSignature());
    }

    /**
     * Find key for signature
     *
     * @param Member $member
     * @param Signature $signature
     * @return Key|null
     */
    private static function getSigningKey($member, $signature)
    {
        if ($member == null) {
            return null;
        }

        $keys = $member->getKeys();
        if (empty($keys)) {
            return null;
        }
        $signatureKeyId = $signature->getKeyId();

        /** @var Key $keyItem */
        foreach ($keys->getIterator() as $keyItem) {

            if ($keyItem->getId() == $signatureKeyId) {
                return $keyItem;
            }
        }
        return null;
    }
}