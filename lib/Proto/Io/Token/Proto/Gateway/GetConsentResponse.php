<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetConsentResponse</code>
 */
class GetConsentResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent consent = 1;</code>
     */
    private $consent = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Consent\Consent $consent
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent consent = 1;</code>
     * @return \Io\Token\Proto\Common\Consent\Consent
     */
    public function getConsent()
    {
        return $this->consent;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent consent = 1;</code>
     * @param \Io\Token\Proto\Common\Consent\Consent $var
     * @return $this
     */
    public function setConsent($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\Consent::class);
        $this->consent = $var;

        return $this;
    }

}

