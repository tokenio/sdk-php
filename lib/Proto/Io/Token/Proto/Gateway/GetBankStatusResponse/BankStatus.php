<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway\GetBankStatusResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetBankStatusResponse.BankStatus</code>
 */
class BankStatus extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string bank_name = 1;</code>
     */
    private $bank_name = '';
    /**
     * Generated from protobuf field <code>string ais_status = 2;</code>
     */
    private $ais_status = '';
    /**
     * Generated from protobuf field <code>string pis_status = 3;</code>
     */
    private $pis_status = '';
    /**
     * Generated from protobuf field <code>string last_updated_at = 4;</code>
     */
    private $last_updated_at = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $bank_name
     *     @type string $ais_status
     *     @type string $pis_status
     *     @type string $last_updated_at
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string bank_name = 1;</code>
     * @return string
     */
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * Generated from protobuf field <code>string bank_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBankName($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string ais_status = 2;</code>
     * @return string
     */
    public function getAisStatus()
    {
        return $this->ais_status;
    }

    /**
     * Generated from protobuf field <code>string ais_status = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setAisStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->ais_status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pis_status = 3;</code>
     * @return string
     */
    public function getPisStatus()
    {
        return $this->pis_status;
    }

    /**
     * Generated from protobuf field <code>string pis_status = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPisStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->pis_status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string last_updated_at = 4;</code>
     * @return string
     */
    public function getLastUpdatedAt()
    {
        return $this->last_updated_at;
    }

    /**
     * Generated from protobuf field <code>string last_updated_at = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setLastUpdatedAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->last_updated_at = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(BankStatus::class, \Io\Token\Proto\Gateway\GetBankStatusResponse_BankStatus::class);

