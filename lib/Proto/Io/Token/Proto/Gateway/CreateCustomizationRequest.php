<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.CreateCustomizationRequest</code>
 */
class CreateCustomizationRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload logo = 1;</code>
     */
    private $logo = null;
    /**
     * Generated from protobuf field <code>map<string, string> colors = 2;</code>
     */
    private $colors;
    /**
     * Generated from protobuf field <code>string consent_text = 3;</code>
     */
    private $consent_text = '';
    /**
     * Generated from protobuf field <code>string name = 4;</code>
     */
    private $name = '';
    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     */
    private $app_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Blob\Blob\Payload $logo
     *     @type array|\Google\Protobuf\Internal\MapField $colors
     *     @type string $consent_text
     *     @type string $name
     *     @type string $app_name
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload logo = 1;</code>
     * @return \Io\Token\Proto\Common\Blob\Blob\Payload
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.blob.Blob.Payload logo = 1;</code>
     * @param \Io\Token\Proto\Common\Blob\Blob\Payload $var
     * @return $this
     */
    public function setLogo($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Blob\Blob_Payload::class);
        $this->logo = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>map<string, string> colors = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Generated from protobuf field <code>map<string, string> colors = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setColors($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->colors = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string consent_text = 3;</code>
     * @return string
     */
    public function getConsentText()
    {
        return $this->consent_text;
    }

    /**
     * Generated from protobuf field <code>string consent_text = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setConsentText($var)
    {
        GPBUtil::checkString($var, True);
        $this->consent_text = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string name = 4;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>string name = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     * @return string
     */
    public function getAppName()
    {
        return $this->app_name;
    }

    /**
     * Generated from protobuf field <code>string app_name = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setAppName($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_name = $var;

        return $this;
    }

}
