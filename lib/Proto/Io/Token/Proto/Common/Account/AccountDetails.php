<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: account.proto

namespace Io\Token\Proto\Common\Account;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Optional account details. Structure of the data is dependent on the underlying bank and is
 * subject to change.
 *
 * Generated from protobuf message <code>io.token.proto.common.account.AccountDetails</code>
 */
class AccountDetails extends \Google\Protobuf\Internal\Message
{
    /**
     * Bank account identifier
     *
     * Generated from protobuf field <code>string identifier = 1;</code>
     */
    private $identifier = '';
    /**
     * Type of account
     *
     * Generated from protobuf field <code>.io.token.proto.common.account.AccountDetails.AccountType type = 2;</code>
     */
    private $type = 0;
    /**
     * Status of account. E.g., "Active/Inactive/Frozen/Dormant"
     *
     * Generated from protobuf field <code>string status = 3;</code>
     */
    private $status = '';
    /**
     * Additional account metadata
     *
     * Generated from protobuf field <code>map<string, string> metadata = 4 [(.io.token.proto.extensions.field.redact) = true];</code>
     */
    private $metadata;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderAccountDetails provider_specific = 5;</code>
     */
    private $provider_specific = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $identifier
     *           Bank account identifier
     *     @type int $type
     *           Type of account
     *     @type string $status
     *           Status of account. E.g., "Active/Inactive/Frozen/Dormant"
     *     @type array|\Google\Protobuf\Internal\MapField $metadata
     *           Additional account metadata
     *     @type \Io\Token\Proto\Common\Providerspecific\ProviderAccountDetails $provider_specific
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Account::initOnce();
        parent::__construct($data);
    }

    /**
     * Bank account identifier
     *
     * Generated from protobuf field <code>string identifier = 1;</code>
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Bank account identifier
     *
     * Generated from protobuf field <code>string identifier = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setIdentifier($var)
    {
        GPBUtil::checkString($var, True);
        $this->identifier = $var;

        return $this;
    }

    /**
     * Type of account
     *
     * Generated from protobuf field <code>.io.token.proto.common.account.AccountDetails.AccountType type = 2;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Type of account
     *
     * Generated from protobuf field <code>.io.token.proto.common.account.AccountDetails.AccountType type = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Account\AccountDetails_AccountType::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Status of account. E.g., "Active/Inactive/Frozen/Dormant"
     *
     * Generated from protobuf field <code>string status = 3;</code>
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status of account. E.g., "Active/Inactive/Frozen/Dormant"
     *
     * Generated from protobuf field <code>string status = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

    /**
     * Additional account metadata
     *
     * Generated from protobuf field <code>map<string, string> metadata = 4 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Additional account metadata
     *
     * Generated from protobuf field <code>map<string, string> metadata = 4 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setMetadata($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->metadata = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderAccountDetails provider_specific = 5;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\ProviderAccountDetails
     */
    public function getProviderSpecific()
    {
        return $this->provider_specific;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderAccountDetails provider_specific = 5;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\ProviderAccountDetails $var
     * @return $this
     */
    public function setProviderSpecific($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\ProviderAccountDetails::class);
        $this->provider_specific = $var;

        return $this;
    }

}

