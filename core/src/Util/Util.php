<?php

namespace Tokenio\Util;

use Google\Protobuf\Internal\Message;
use Grpc\UnaryCall;
use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Member\Member;
use Io\Token\Proto\Common\Member\MemberAddKeyOperation;
use Io\Token\Proto\Common\Member\MemberAliasOperation;
use Io\Token\Proto\Common\Member\MemberOperation;
use Io\Token\Proto\Common\Member\MemberOperationMetadata;
use Io\Token\Proto\Common\Member\MemberRecoveryRulesOperation;
use Io\Token\Proto\Common\Member\RecoveryRule;
use Io\Token\Proto\Common\Security\Key;
use ReflectionClass;
use ReflectionException;
use stdClass;
use Tokenio\Exception;
use const Grpc\STATUS_OK;

abstract class Util
{
    /**
     * Converts Key to AddKey operation.
     *
     * @param Key $key the key to add
     * @return MemberOperation operation
     */
    public static function toAddKeyOperation($key)
    {
        $memberAddKeyOperation = new MemberAddKeyOperation();
        $memberAddKeyOperation->setKey($key);

        $operation = new MemberOperation();
        $operation->setAddKey($memberAddKeyOperation);

        return $operation;
    }

    /**
     * Converts agent id to AddKey operation.
     *
     * @param string $agentId the agent id to add
     * @return MemberOperation operation
     */
    public static function toRecoveryAgentOperation($agentId)
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
     * Converts alias to AddAlias operation.
     *
     * @param Alias $alias
     * @return MemberOperation
     * @throws \Exception
     */
    public static function toAddAliasOperation($alias)
    {
        $aliasOperation = new MemberAliasOperation();
        $aliasOperation->setAliasHash(self::normalizeAndHashAlias($alias));
        $aliasOperation->setRealm($alias->getRealm());
        $aliasOperation->setRealmId($alias->getRealmId());

        $operation = new MemberOperation();
        $operation->setAddAlias($aliasOperation);

        return $operation;
    }

    /**
     * Normalizes alias and converts to alias hash.
     *
     * @param Alias $rawAlias { EMAIL, "Captain@gmail.com" }
     * @return string
     * @throws \Exception
     */
    public static function normalizeAndHashAlias($rawAlias)
    {
        return self::hashAlias(self::normalize($rawAlias));
    }

    /**
     * Hash Alias as Base58 hashed json from Alias message
     *
     * @param Alias $alias the alias to hash
     * @return string
     * @throws \Exception
     */
    public static function hashAlias($alias)
    {
        if ($alias->getType() == Alias\Type::USERNAME) {
            return $alias->getValue();
        }

        $aliasClone = clone $alias;
        $aliasClone->setRealm("");

        return Base58::encode(self::sha256hash(self::toJson($aliasClone)));
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
     * Sort JSON
     *
     * @param string $data
     * @return string
     */
    private static function normalizeJson($data)
    {
        $jsonOriginal = json_decode($data, false);
        $json = json_decode($data, true);
        if ($json == null) {
            return $data;
        }
        self::jsonSort($json);
        self::fixEmptyObjectReplacements($jsonOriginal, $json, '');
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

    private static function fixEmptyObjectReplacements($originalJson, &$object, $path)
    {
        foreach ($object as $key => &$value) {

            if (is_array($value) && empty($value) && !Strings::isEmptyString($path)) {
                $pathParts = array_diff(explode(';', $path), ['', null]);
                $srcObj = $originalJson;
                foreach ($pathParts as $part) {
                    $srcObj = is_object($srcObj) ? $srcObj->$part : $srcObj[$part];
                }
                if (is_object($srcObj->$key)) {
                    if (!($object[$key] instanceof stdClass)) {
                        $object[$key] = new stdClass();
                    }
                    return;

                }
            } else if (is_object($value) || is_array($value)) {
                $path = $path . ';' . $key;
                self::fixEmptyObjectReplacements($originalJson, $value, $path);
            }
        }
    }

    /**
     * Get alias with normalized value. E.g. "Captain@gmail.com" to "captain@gmail.com".
     *
     * @param Alias $rawAlias { EMAIL, "Captain@gmail.com" }
     * @return Alias with possibly-different value field
     */
    public static function normalize($rawAlias)
    {
        if ($rawAlias->getType() == Alias\Type::EIDAS) {
            return $rawAlias->setValue(trim($rawAlias->getValue()));
        }
        return $rawAlias->setValue(strtolower(trim($rawAlias->getValue())));
    }

    /**
     * Converts alias to MemberOperationMetadata.
     *
     * @param Alias $alias
     * @return MemberOperationMetadata
     * @throws \Exception
     */
    public static function toAddAliasOperationMetadata($alias)
    {
        $normalized = self::normalize($alias);
        $aliasMetadata = new MemberOperationMetadata\AddAliasMetadata();
        $aliasMetadata->setAlias($normalized);
        $aliasMetadata->setAliasHash(self::normalizeAndHashAlias($normalized));

        $metadata = new MemberOperationMetadata();
        $metadata->setAddAliasMetadata($aliasMetadata);

        return $metadata;
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
     * Hash Alias as Base58 hashed json from Alias message
     *
     * @param Message $message the alias to hash
     * @return string
     * @throws \Exception
     */
    public static function hashProto($message)
    {
        return Base58::encode(self::sha256hash($message->serializeToString()));
    }

    /**
     * Creates MemberOperation from Keys
     * @param Key[] $keys
     * @return MemberOperation[]
     */
    public static function toAddKeyOperations($keys)
    {
        $operations = array();
        foreach ($keys as $key) {
            $addKeyOperation = new MemberAddKeyOperation();
            $addKeyOperation->setKey($key);

            $operation = new MemberOperation();
            $operation->setAddKey($addKeyOperation);
            $operations[] = $operation;
        }
        return $operations;
    }

    /**
     * Executes UnaryCall and handles status and response
     *
     * @param UnaryCall $call
     * @return Message returned by the server
     * @throws Exception\StatusRuntimeException exception returned by server
     */
    public static function executeAndHandleCall($call)
    {
        list($response, $status) = $call->wait();

        if ($status->code == STATUS_OK) {
            return $response;
        } else {
            throw new Exception\StatusRuntimeException($status->code, $status->details);
        }
    }

    /**
     * Use reflection to return all constants as (value, constant name) array from the class
     * @param $classname
     * @return array|null
     * @throws ReflectionException
     */
    public static function reflectEnum($classname)
    {
        $clazz = new ReflectionClass($classname);
        return array_flip($clazz->getConstants());
    }
}
