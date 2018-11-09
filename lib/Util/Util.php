<?php

namespace Tokenio\Util;

use Google\Protobuf\Internal\Message;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberAddKeyOperation;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberOperationMetadata;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Security\Key;
use Io\Token\Proto\Common\Security\Signature;
use Io\Token\Proto\Common\Token\TokenRequestStatePayload;
use Tokenio\Exception;
use Tokenio\Exception\CryptoKeyNotFoundException;
use Tokenio\Security\Base58;
use Tokenio\Security\Base64Url;
use Tokenio\Security\Ed25519Verifier;

abstract class Util
{
    /**
     * Converts message to normalized json string
     *
     * @param Message $message
     * @return string
     */
    public static function toJson($message)
    {
        $json = $message->serializeToJsonString();
        return self::normalizeJson($json);
    }

    /**
     * Hash Alias as Base58 hashed json from Alias message
     *
     * @param Alias $alias the alias to hash
     * @return string
     * @throws \Tokenio\Exception\CryptographicException
     */
    public static function hashAlias($alias)
    {
        if ($alias->getType() == Alias\Type::USERNAME) {
            return $alias->getValue();
        }

        return Base58::encode(self::sha256hash(self::toJson($alias)));
    }

    /**
     * Creates AddKey operation with Key.
     *
     * @param Key $key the key to add
     * @return MemberOperation operation
     */
    public static function createAddKeyMemberOperation($key)
    {
        $memberAddKeyOperation = new MemberAddKeyOperation();
        $memberAddKeyOperation->setKey($key);

        $operation = new MemberOperation();
        $operation->setAddKey($memberAddKeyOperation);

        return $operation;
    }

    /**
     * Creates AddAlias operation with Alias.
     *
     * @param Alias $alias
     * @return MemberOperation
     * @throws \Tokenio\Exception\CryptographicException
     */
    public static function createAddAliasOperation($alias)
    {
        $aliasOperation = new MemberAliasOperation();
        $aliasOperation->setAliasHash(self::hashAlias($alias));
        $aliasOperation->setRealm($alias->getRealm());

        $operation = new MemberOperation();
        $operation->setAddAlias($aliasOperation);

        return $operation;
    }

    /**
     * Creates MemberOperationMetadata with Alias.
     *
     * @param Alias $alias
     * @return MemberOperationMetadata
     * @throws Exception\CryptographicException
     */
    public static function createAddAliasOperationMetadata($alias)
    {
        $aliasMetadata = new MemberOperationMetadata\AddAliasMetadata();
        $aliasMetadata->setAlias($alias);
        $aliasMetadata->setAliasHash(self::hashAlias($alias));

        $metadata = new MemberOperationMetadata();
        $metadata->setAddAliasMetadata($aliasMetadata);

        return $metadata;
    }

    /**
     * Creates agent operation with agent id.
     *
     * @param string $agentId the agent id to add
     * @return MemberOperation operation
     */
    public static function createRecoveryAgentOperation($agentId)
    {
        $recoveryRule = new RecoveryRule();
        $recoveryRule->setPrimaryAgent($agentId);

        $rules = new MemberRecoveryRulesOperation();
        $rules->setRecoveryRule($recoveryRule);

        $operation = new MemberOperation();
        $operation->setRecoveryRules($rules);

        return $operation;
    }

    /**
     * Get alias with normalized value. E.g. "Captain@gmail.com" to "captain@gmail.com".
     *
     * @param Alias $rawAlias { EMAIL, "Captain@gmail.com" }
     * @return Alias with possibly-different value field
     */
    public static function normalizeAlias($rawAlias)
    {
        switch ($rawAlias->getType()) {
            case Alias\Type::EMAIL:
            case Alias\Type::DOMAIN:
                return $rawAlias->setValue(strtolower(trim($rawAlias->getValue())));

            default:
                return $rawAlias;
        }
    }

    /**
     * Hash data with SHA256 as hex string
     *
     * @param string $data
     * @return string
     */
    public static function hashString($data)
    {
        return hash('sha256', $data);
    }

    /**
     * Verify signature for payload
     *
     * @param Member $member
     * @param TokenRequestStatePayload $payload
     * @param Signature $signature
     * @throws CryptoKeyNotFoundException
     * @throws Exception\CryptographicException
     */
    public static function verifySignature($member, $payload, $signature)
    {
        $key = self::findKey($member, $signature);

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
    private static function findKey($member, $signature)
    {
        if ($member == null) {
            return null;
        }

        $keys = $member->getKeys();
        if (empty($keys)) {
            return null;
        }

        /** @var Key $keyItem */
        foreach ($keys->getIterator() as $keyItem) {
            if ($keyItem->getId() == $signature->getKeyId()) {
                return $keyItem;
            }
        }

        return null;
    }

    /**
     * Hash data with SHA256
     *
     * @param string $payload
     * @return string
     */
    private static function sha256hash($payload)
    {
        return hash('sha256', $payload, true);
    }

    /**
     * Sort JSON
     *
     * @param string $data
     * @return string
     */
    private static function normalizeJson($data)
    {
        $json = json_decode($data, true);
        if ($json == null) {
            return $data;
        }

        self::jsonSort($json);
        return json_encode($json);
    }

    /**
     * Sort array keys
     *
     * @param $array
     */
    private static function jsonSort(&$array)
    {
        ksort($array);
        foreach (array_keys($array) as $key) {
            if (is_array($array[$key])) {
                self::jsonSort($array[$key]);
            }
        }
    }
}
