<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: consent.proto

namespace Io\Token\Proto\Common\Consent;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.consent.CreateConsent</code>
 */
class CreateConsent extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     */
    private $user_id = '';
    /**
     * Generated from protobuf field <code>string request_id = 2;</code>
     */
    private $request_id = '';
    protected $type;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $user_id
     *     @type string $request_id
     *     @type \Io\Token\Proto\Common\Consent\CreateConsent\ResourceTypeAccess $resource_type_access
     *     @type \Io\Token\Proto\Common\Consent\CreateConsent\AccountResourceAccess $account_resource_access
     *     @type \Io\Token\Proto\Common\Consent\CreateConsent\Transfer $transfer
     *     @type \Io\Token\Proto\Common\Consent\CreateConsent\StandingOrder $standing_order
     *     @type \Io\Token\Proto\Common\Consent\CreateConsent\BulkTransfer $bulk_transfer
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Consent::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string request_id = 2;</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Generated from protobuf field <code>string request_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.ResourceTypeAccess resource_type_access = 3;</code>
     * @return \Io\Token\Proto\Common\Consent\CreateConsent\ResourceTypeAccess
     */
    public function getResourceTypeAccess()
    {
        return $this->readOneof(3);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.ResourceTypeAccess resource_type_access = 3;</code>
     * @param \Io\Token\Proto\Common\Consent\CreateConsent\ResourceTypeAccess $var
     * @return $this
     */
    public function setResourceTypeAccess($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\CreateConsent_ResourceTypeAccess::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.AccountResourceAccess account_resource_access = 4;</code>
     * @return \Io\Token\Proto\Common\Consent\CreateConsent\AccountResourceAccess
     */
    public function getAccountResourceAccess()
    {
        return $this->readOneof(4);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.AccountResourceAccess account_resource_access = 4;</code>
     * @param \Io\Token\Proto\Common\Consent\CreateConsent\AccountResourceAccess $var
     * @return $this
     */
    public function setAccountResourceAccess($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\CreateConsent_AccountResourceAccess::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.Transfer transfer = 5;</code>
     * @return \Io\Token\Proto\Common\Consent\CreateConsent\Transfer
     */
    public function getTransfer()
    {
        return $this->readOneof(5);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.Transfer transfer = 5;</code>
     * @param \Io\Token\Proto\Common\Consent\CreateConsent\Transfer $var
     * @return $this
     */
    public function setTransfer($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\CreateConsent_Transfer::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.StandingOrder standing_order = 6;</code>
     * @return \Io\Token\Proto\Common\Consent\CreateConsent\StandingOrder
     */
    public function getStandingOrder()
    {
        return $this->readOneof(6);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.StandingOrder standing_order = 6;</code>
     * @param \Io\Token\Proto\Common\Consent\CreateConsent\StandingOrder $var
     * @return $this
     */
    public function setStandingOrder($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\CreateConsent_StandingOrder::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.BulkTransfer bulk_transfer = 7;</code>
     * @return \Io\Token\Proto\Common\Consent\CreateConsent\BulkTransfer
     */
    public function getBulkTransfer()
    {
        return $this->readOneof(7);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.CreateConsent.BulkTransfer bulk_transfer = 7;</code>
     * @param \Io\Token\Proto\Common\Consent\CreateConsent\BulkTransfer $var
     * @return $this
     */
    public function setBulkTransfer($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\CreateConsent_BulkTransfer::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->whichOneof("type");
    }

}

