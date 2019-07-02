<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: bankinfo.proto

namespace Io\Token\Proto\Common\Bank;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Depending on how user can interact with bank,
 * different fields will have values.
 *   BankAuthorization JSON: User interacts with web site, goes to JSON uri
 *   OAuth: User interacts with web site, gets OAuth access token
 *
 * Generated from protobuf message <code>io.token.proto.common.bank.BankInfo</code>
 */
class BankInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * BankAuthorization JSON starting URI
     *
     * Generated from protobuf field <code>string linking_uri = 1;</code>
     */
    private $linking_uri = '';
    /**
     * BankAuthorization JSON success URI pattern
     *
     * Generated from protobuf field <code>string redirect_uri_regex = 2;</code>
     */
    private $redirect_uri_regex = '';
    /**
     * OAuth starting URI
     *
     * Generated from protobuf field <code>string bank_linking_uri = 3;</code>
     */
    private $bank_linking_uri = '';
    /**
     * (Optional) Realms of the bank
     *
     * Generated from protobuf field <code>repeated string realm = 4;</code>
     */
    private $realm;
    /**
     * (Optional) Label to be displayed if bank supports custom aliases
     *
     * Generated from protobuf field <code>string custom_alias_label = 6;</code>
     */
    private $custom_alias_label = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $linking_uri
     *           BankAuthorization JSON starting URI
     *     @type string $redirect_uri_regex
     *           BankAuthorization JSON success URI pattern
     *     @type string $bank_linking_uri
     *           OAuth starting URI
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $realm
     *           (Optional) Realms of the bank
     *     @type string $custom_alias_label
     *           (Optional) Label to be displayed if bank supports custom aliases
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Bankinfo::initOnce();
        parent::__construct($data);
    }

    /**
     * BankAuthorization JSON starting URI
     *
     * Generated from protobuf field <code>string linking_uri = 1;</code>
     * @return string
     */
    public function getLinkingUri()
    {
        return $this->linking_uri;
    }

    /**
     * BankAuthorization JSON starting URI
     *
     * Generated from protobuf field <code>string linking_uri = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setLinkingUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->linking_uri = $var;

        return $this;
    }

    /**
     * BankAuthorization JSON success URI pattern
     *
     * Generated from protobuf field <code>string redirect_uri_regex = 2;</code>
     * @return string
     */
    public function getRedirectUriRegex()
    {
        return $this->redirect_uri_regex;
    }

    /**
     * BankAuthorization JSON success URI pattern
     *
     * Generated from protobuf field <code>string redirect_uri_regex = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRedirectUriRegex($var)
    {
        GPBUtil::checkString($var, True);
        $this->redirect_uri_regex = $var;

        return $this;
    }

    /**
     * OAuth starting URI
     *
     * Generated from protobuf field <code>string bank_linking_uri = 3;</code>
     * @return string
     */
    public function getBankLinkingUri()
    {
        return $this->bank_linking_uri;
    }

    /**
     * OAuth starting URI
     *
     * Generated from protobuf field <code>string bank_linking_uri = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setBankLinkingUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_linking_uri = $var;

        return $this;
    }

    /**
     * (Optional) Realms of the bank
     *
     * Generated from protobuf field <code>repeated string realm = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * (Optional) Realms of the bank
     *
     * Generated from protobuf field <code>repeated string realm = 4;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRealm($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->realm = $arr;

        return $this;
    }

    /**
     * (Optional) Label to be displayed if bank supports custom aliases
     *
     * Generated from protobuf field <code>string custom_alias_label = 6;</code>
     * @return string
     */
    public function getCustomAliasLabel()
    {
        return $this->custom_alias_label;
    }

    /**
     * (Optional) Label to be displayed if bank supports custom aliases
     *
     * Generated from protobuf field <code>string custom_alias_label = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setCustomAliasLabel($var)
    {
        GPBUtil::checkString($var, True);
        $this->custom_alias_label = $var;

        return $this;
    }

}

