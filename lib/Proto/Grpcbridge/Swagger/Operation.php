<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: grpcbridge/swagger/openapi_v2.proto

namespace Grpcbridge\Swagger;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * https://github.com/OAI/OpenAPI-Specification/blob/3.0.0/versions/2.0.md#operationObject
 *
 * Generated from protobuf message <code>grpcbridge.swagger.Operation</code>
 */
class Operation extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated string tags = 2;</code>
     */
    private $tags;
    /**
     * Generated from protobuf field <code>string summary = 3;</code>
     */
    private $summary = '';
    /**
     * Generated from protobuf field <code>string description = 4;</code>
     */
    private $description = '';
    /**
     * Generated from protobuf field <code>bool deprecated = 5;</code>
     */
    private $deprecated = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $tags
     *     @type string $summary
     *     @type string $description
     *     @type bool $deprecated
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Grpcbridge\Swagger\OpenapiV2::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated string tags = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Generated from protobuf field <code>repeated string tags = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTags($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->tags = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string summary = 3;</code>
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Generated from protobuf field <code>string summary = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSummary($var)
    {
        GPBUtil::checkString($var, True);
        $this->summary = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string description = 4;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Generated from protobuf field <code>string description = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool deprecated = 5;</code>
     * @return bool
     */
    public function getDeprecated()
    {
        return $this->deprecated;
    }

    /**
     * Generated from protobuf field <code>bool deprecated = 5;</code>
     * @param bool $var
     * @return $this
     */
    public function setDeprecated($var)
    {
        GPBUtil::checkBool($var);
        $this->deprecated = $var;

        return $this;
    }

}

