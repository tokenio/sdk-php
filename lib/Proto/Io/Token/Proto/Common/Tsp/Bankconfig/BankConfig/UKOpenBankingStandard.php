<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: tsp/bankconfig.proto

namespace Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.tsp.bankconfig.BankConfig.UKOpenBankingStandard</code>
 */
class UKOpenBankingStandard extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string organisation_id = 1;</code>
     */
    private $organisation_id = '';
    /**
     * Generated from protobuf field <code>string software_statement_id = 2;</code>
     */
    private $software_statement_id = '';
    /**
     * client-secret-basic, client-secret-post, tls-client-auth, private-key-jwt
     *
     * Generated from protobuf field <code>string authentication_type = 3;</code>
     */
    private $authentication_type = '';
    /**
     * Generated from protobuf field <code>string client_id = 4;</code>
     */
    private $client_id = '';
    /**
     * optional, depending on the authentication_type
     *
     * Generated from protobuf field <code>string client_secret = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
     */
    private $client_secret = '';
    /**
     * created by Open Banking Directory
     *
     * Generated from protobuf field <code>string jwt_signing_key_id = 6;</code>
     */
    private $jwt_signing_key_id = '';
    /**
     * RS256, PS256, etc
     *
     * Generated from protobuf field <code>string jwt_signing_algorithm = 7;</code>
     */
    private $jwt_signing_algorithm = '';
    /**
     * Generated from protobuf field <code>string signing_key_id = 8;</code>
     */
    private $signing_key_id = '';
    /**
     * Generated from protobuf field <code>string transport_key_id = 9;</code>
     */
    private $transport_key_id = '';
    /**
     * Generated from protobuf field <code>bool is_eidas = 10;</code>
     */
    private $is_eidas = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $organisation_id
     *     @type string $software_statement_id
     *     @type string $authentication_type
     *           client-secret-basic, client-secret-post, tls-client-auth, private-key-jwt
     *     @type string $client_id
     *     @type string $client_secret
     *           optional, depending on the authentication_type
     *     @type string $jwt_signing_key_id
     *           created by Open Banking Directory
     *     @type string $jwt_signing_algorithm
     *           RS256, PS256, etc
     *     @type string $signing_key_id
     *     @type string $transport_key_id
     *     @type bool $is_eidas
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Tsp\Bankconfig::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string organisation_id = 1;</code>
     * @return string
     */
    public function getOrganisationId()
    {
        return $this->organisation_id;
    }

    /**
     * Generated from protobuf field <code>string organisation_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setOrganisationId($var)
    {
        GPBUtil::checkString($var, True);
        $this->organisation_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string software_statement_id = 2;</code>
     * @return string
     */
    public function getSoftwareStatementId()
    {
        return $this->software_statement_id;
    }

    /**
     * Generated from protobuf field <code>string software_statement_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSoftwareStatementId($var)
    {
        GPBUtil::checkString($var, True);
        $this->software_statement_id = $var;

        return $this;
    }

    /**
     * client-secret-basic, client-secret-post, tls-client-auth, private-key-jwt
     *
     * Generated from protobuf field <code>string authentication_type = 3;</code>
     * @return string
     */
    public function getAuthenticationType()
    {
        return $this->authentication_type;
    }

    /**
     * client-secret-basic, client-secret-post, tls-client-auth, private-key-jwt
     *
     * Generated from protobuf field <code>string authentication_type = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAuthenticationType($var)
    {
        GPBUtil::checkString($var, True);
        $this->authentication_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string client_id = 4;</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Generated from protobuf field <code>string client_id = 4;</code>
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
     * optional, depending on the authentication_type
     *
     * Generated from protobuf field <code>string client_secret = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * optional, depending on the authentication_type
     *
     * Generated from protobuf field <code>string client_secret = 5 [(.io.token.proto.extensions.field.redact) = true];</code>
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
     * created by Open Banking Directory
     *
     * Generated from protobuf field <code>string jwt_signing_key_id = 6;</code>
     * @return string
     */
    public function getJwtSigningKeyId()
    {
        return $this->jwt_signing_key_id;
    }

    /**
     * created by Open Banking Directory
     *
     * Generated from protobuf field <code>string jwt_signing_key_id = 6;</code>
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
     * RS256, PS256, etc
     *
     * Generated from protobuf field <code>string jwt_signing_algorithm = 7;</code>
     * @return string
     */
    public function getJwtSigningAlgorithm()
    {
        return $this->jwt_signing_algorithm;
    }

    /**
     * RS256, PS256, etc
     *
     * Generated from protobuf field <code>string jwt_signing_algorithm = 7;</code>
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
     * Generated from protobuf field <code>string signing_key_id = 8;</code>
     * @return string
     */
    public function getSigningKeyId()
    {
        return $this->signing_key_id;
    }

    /**
     * Generated from protobuf field <code>string signing_key_id = 8;</code>
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
     * Generated from protobuf field <code>string transport_key_id = 9;</code>
     * @return string
     */
    public function getTransportKeyId()
    {
        return $this->transport_key_id;
    }

    /**
     * Generated from protobuf field <code>string transport_key_id = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setTransportKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->transport_key_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool is_eidas = 10;</code>
     * @return bool
     */
    public function getIsEidas()
    {
        return $this->is_eidas;
    }

    /**
     * Generated from protobuf field <code>bool is_eidas = 10;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsEidas($var)
    {
        GPBUtil::checkBool($var);
        $this->is_eidas = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(UKOpenBankingStandard::class, \Io\Token\Proto\Common\Tsp\Bankconfig\BankConfig_UKOpenBankingStandard::class);

