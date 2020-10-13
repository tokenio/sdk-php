<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: tsp/bankconfig.proto

namespace Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.tsp.bankconfig.BankConfig.StetPsd2Standard</code>
 */
class StetPsd2Standard extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string client_id = 1;</code>
     */
    private $client_id = '';
    /**
     * Generated from protobuf field <code>string client_secret = 2;</code>
     */
    private $client_secret = '';
    /**
     * Generated from protobuf field <code>string jwt_signing_key_id = 3;</code>
     */
    private $jwt_signing_key_id = '';
    /**
     * Generated from protobuf field <code>string jwt_signing_algorithm = 4;</code>
     */
    private $jwt_signing_algorithm = '';
    /**
     * Generated from protobuf field <code>string signing_key_id = 5;</code>
     */
    private $signing_key_id = '';
    /**
     * Generated from protobuf field <code>string transport_key_id = 6;</code>
     */
    private $transport_key_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $client_id
     *     @type string $client_secret
     *     @type string $jwt_signing_key_id
     *     @type string $jwt_signing_algorithm
     *     @type string $signing_key_id
     *     @type string $transport_key_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Tsp\Bankconfig::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string client_id = 1;</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Generated from protobuf field <code>string client_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string client_secret = 2;</code>
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Generated from protobuf field <code>string client_secret = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setClientSecret($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_secret = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string jwt_signing_key_id = 3;</code>
     * @return string
     */
    public function getJwtSigningKeyId()
    {
        return $this->jwt_signing_key_id;
    }

    /**
     * Generated from protobuf field <code>string jwt_signing_key_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setJwtSigningKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->jwt_signing_key_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string jwt_signing_algorithm = 4;</code>
     * @return string
     */
    public function getJwtSigningAlgorithm()
    {
        return $this->jwt_signing_algorithm;
    }

    /**
     * Generated from protobuf field <code>string jwt_signing_algorithm = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setJwtSigningAlgorithm($var)
    {
        GPBUtil::checkString($var, True);
        $this->jwt_signing_algorithm = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string signing_key_id = 5;</code>
     * @return string
     */
    public function getSigningKeyId()
    {
        return $this->signing_key_id;
    }

    /**
     * Generated from protobuf field <code>string signing_key_id = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setSigningKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->signing_key_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string transport_key_id = 6;</code>
     * @return string
     */
    public function getTransportKeyId()
    {
        return $this->transport_key_id;
    }

    /**
     * Generated from protobuf field <code>string transport_key_id = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setTransportKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->transport_key_id = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(StetPsd2Standard::class, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_StetPsd2Standard::class);
