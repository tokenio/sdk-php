<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.InitiateBankAuthorizationResponse</code>
 */
class InitiateBankAuthorizationResponse extends \Google\Protobuf\Internal\Message
{
    protected $result;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $redirect_url
     *           URL for bank authorization
     *     @type int $status
     *           if SCA process has finished, whether it succeeded or not
     *     @type \Io\Token\Proto\Gateway\InitiateBankAuthorizationResponse\CredentialFields $fields
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * URL for bank authorization
     *
     * Generated from protobuf field <code>string redirect_url = 1;</code>
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->readOneof(1);
    }

    /**
     * URL for bank authorization
     *
     * Generated from protobuf field <code>string redirect_url = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRedirectUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * if SCA process has finished, whether it succeeded or not
     *
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ScaStatus status = 2;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->readOneof(2);
    }

    /**
     * if SCA process has finished, whether it succeeded or not
     *
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ScaStatus status = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Providerspecific\ScaStatus::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.gateway.InitiateBankAuthorizationResponse.CredentialFields fields = 3;</code>
     * @return \Io\Token\Proto\Gateway\InitiateBankAuthorizationResponse\CredentialFields
     */
    public function getFields()
    {
        return $this->readOneof(3);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.gateway.InitiateBankAuthorizationResponse.CredentialFields fields = 3;</code>
     * @param \Io\Token\Proto\Gateway\InitiateBankAuthorizationResponse\CredentialFields $var
     * @return $this
     */
    public function setFields($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Gateway\InitiateBankAuthorizationResponse_CredentialFields::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->whichOneof("result");
    }

}

