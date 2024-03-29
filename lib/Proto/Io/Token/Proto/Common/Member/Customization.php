<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member.proto

namespace Io\Token\Proto\Common\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.member.Customization</code>
 */
class Customization extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string customization_id = 1;</code>
     */
    private $customization_id = '';
    /**
     * display name
     *
     * Generated from protobuf field <code>string name = 5;</code>
     */
    private $name = '';
    /**
     * logo blob id
     *
     * Generated from protobuf field <code>string logo_blob_id = 2;</code>
     */
    private $logo_blob_id = '';
    /**
     * colors in hex string #AARRGGBB
     *
     * Generated from protobuf field <code>map<string, string> colors = 3;</code>
     */
    private $colors;
    /**
     * use '\n' for line breaks.
     *
     * Generated from protobuf field <code>string consent_text = 4;</code>
     */
    private $consent_text = '';
    /**
     * TODO(RD-1985): re-evaluate app_name
     *
     * Generated from protobuf field <code>string app_name = 6;</code>
     */
    private $app_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $customization_id
     *     @type string $name
     *           display name
     *     @type string $logo_blob_id
     *           logo blob id
     *     @type array|\Google\Protobuf\Internal\MapField $colors
     *           colors in hex string #AARRGGBB
     *     @type string $consent_text
     *           use '\n' for line breaks.
     *     @type string $app_name
     *           TODO(RD-1985): re-evaluate app_name
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Member::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string customization_id = 1;</code>
     * @return string
     */
    public function getCustomizationId()
    {
        return $this->customization_id;
    }

    /**
     * Generated from protobuf field <code>string customization_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCustomizationId($var)
    {
        GPBUtil::checkString($var, True);
        $this->customization_id = $var;

        return $this;
    }

    /**
     * display name
     *
     * Generated from protobuf field <code>string name = 5;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * display name
     *
     * Generated from protobuf field <code>string name = 5;</code>
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
     * logo blob id
     *
     * Generated from protobuf field <code>string logo_blob_id = 2;</code>
     * @return string
     */
    public function getLogoBlobId()
    {
        return $this->logo_blob_id;
    }

    /**
     * logo blob id
     *
     * Generated from protobuf field <code>string logo_blob_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLogoBlobId($var)
    {
        GPBUtil::checkString($var, True);
        $this->logo_blob_id = $var;

        return $this;
    }

    /**
     * colors in hex string #AARRGGBB
     *
     * Generated from protobuf field <code>map<string, string> colors = 3;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * colors in hex string #AARRGGBB
     *
     * Generated from protobuf field <code>map<string, string> colors = 3;</code>
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
     * use '\n' for line breaks.
     *
     * Generated from protobuf field <code>string consent_text = 4;</code>
     * @return string
     */
    public function getConsentText()
    {
        return $this->consent_text;
    }

    /**
     * use '\n' for line breaks.
     *
     * Generated from protobuf field <code>string consent_text = 4;</code>
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
     * TODO(RD-1985): re-evaluate app_name
     *
     * Generated from protobuf field <code>string app_name = 6;</code>
     * @return string
     */
    public function getAppName()
    {
        return $this->app_name;
    }

    /**
     * TODO(RD-1985): re-evaluate app_name
     *
     * Generated from protobuf field <code>string app_name = 6;</code>
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

