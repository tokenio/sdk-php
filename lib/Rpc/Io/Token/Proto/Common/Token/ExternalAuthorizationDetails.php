<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.token.ExternalAuthorizationDetails</code>
 */
class ExternalAuthorizationDetails extends \Google\Protobuf\Internal\Message
{
    /**
     * Deprecated. Display content from this URL to user to prompt for permission
     *
     * Generated from protobuf field <code>string url = 1;</code>
     */
    private $url = '';
    /**
     * Deprecated. If user navigates to URL matching this pattern, interaction is complete
     *
     * Generated from protobuf field <code>string completion_pattern = 2;</code>
     */
    private $completion_pattern = '';
    /**
     * Display content from this URL to user to prompt for permission; initiates OAuth payment flow
     *
     * Generated from protobuf field <code>string authorization_url = 3;</code>
     */
    private $authorization_url = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $url
     *           Deprecated. Display content from this URL to user to prompt for permission
     *     @type string $completion_pattern
     *           Deprecated. If user navigates to URL matching this pattern, interaction is complete
     *     @type string $authorization_url
     *           Display content from this URL to user to prompt for permission; initiates OAuth payment flow
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Token::initOnce();
        parent::__construct($data);
    }

    /**
     * Deprecated. Display content from this URL to user to prompt for permission
     *
     * Generated from protobuf field <code>string url = 1;</code>
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Deprecated. Display content from this URL to user to prompt for permission
     *
     * Generated from protobuf field <code>string url = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->url = $var;

        return $this;
    }

    /**
     * Deprecated. If user navigates to URL matching this pattern, interaction is complete
     *
     * Generated from protobuf field <code>string completion_pattern = 2;</code>
     * @return string
     */
    public function getCompletionPattern()
    {
        return $this->completion_pattern;
    }

    /**
     * Deprecated. If user navigates to URL matching this pattern, interaction is complete
     *
     * Generated from protobuf field <code>string completion_pattern = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCompletionPattern($var)
    {
        GPBUtil::checkString($var, True);
        $this->completion_pattern = $var;

        return $this;
    }

    /**
     * Display content from this URL to user to prompt for permission; initiates OAuth payment flow
     *
     * Generated from protobuf field <code>string authorization_url = 3;</code>
     * @return string
     */
    public function getAuthorizationUrl()
    {
        return $this->authorization_url;
    }

    /**
     * Display content from this URL to user to prompt for permission; initiates OAuth payment flow
     *
     * Generated from protobuf field <code>string authorization_url = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAuthorizationUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->authorization_url = $var;

        return $this;
    }

}

