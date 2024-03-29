<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: notification.proto

namespace Io\Token\Proto\Common\Notification;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.notification.EndorseAndAddKey</code>
 */
class EndorseAndAddKey extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     */
    private $payload = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.notification.AddKey add_key = 2;</code>
     */
    private $add_key = null;
    /**
     * Optional token request ID
     *
     * Generated from protobuf field <code>string token_request_id = 3;</code>
     */
    private $token_request_id = '';
    /**
     * Optional bank ID
     *
     * Generated from protobuf field <code>string bank_id = 4;</code>
     */
    private $bank_id = '';
    /**
     * Optional token request state for signing
     *
     * Generated from protobuf field <code>string state = 5;</code>
     */
    private $state = '';
    /**
     *Optional receipt contact
     *
     * Generated from protobuf field <code>.io.token.proto.common.member.ReceiptContact contact = 6;</code>
     */
    private $contact = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Token\TokenPayload $payload
     *     @type \Io\Token\Proto\Common\Notification\AddKey $add_key
     *     @type string $token_request_id
     *           Optional token request ID
     *     @type string $bank_id
     *           Optional bank ID
     *     @type string $state
     *           Optional token request state for signing
     *     @type \Io\Token\Proto\Common\Member\ReceiptContact $contact
     *          Optional receipt contact
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Notification::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     * @return \Io\Token\Proto\Common\Token\TokenPayload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.TokenPayload payload = 1;</code>
     * @param \Io\Token\Proto\Common\Token\TokenPayload $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\TokenPayload::class);
        $this->payload = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.notification.AddKey add_key = 2;</code>
     * @return \Io\Token\Proto\Common\Notification\AddKey
     */
    public function getAddKey()
    {
        return $this->add_key;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.notification.AddKey add_key = 2;</code>
     * @param \Io\Token\Proto\Common\Notification\AddKey $var
     * @return $this
     */
    public function setAddKey($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Notification\AddKey::class);
        $this->add_key = $var;

        return $this;
    }

    /**
     * Optional token request ID
     *
     * Generated from protobuf field <code>string token_request_id = 3;</code>
     * @return string
     */
    public function getTokenRequestId()
    {
        return $this->token_request_id;
    }

    /**
     * Optional token request ID
     *
     * Generated from protobuf field <code>string token_request_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_request_id = $var;

        return $this;
    }

    /**
     * Optional bank ID
     *
     * Generated from protobuf field <code>string bank_id = 4;</code>
     * @return string
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * Optional bank ID
     *
     * Generated from protobuf field <code>string bank_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setBankId($var)
    {
        GPBUtil::checkString($var, True);
        $this->bank_id = $var;

        return $this;
    }

    /**
     * Optional token request state for signing
     *
     * Generated from protobuf field <code>string state = 5;</code>
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Optional token request state for signing
     *
     * Generated from protobuf field <code>string state = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkString($var, True);
        $this->state = $var;

        return $this;
    }

    /**
     *Optional receipt contact
     *
     * Generated from protobuf field <code>.io.token.proto.common.member.ReceiptContact contact = 6;</code>
     * @return \Io\Token\Proto\Common\Member\ReceiptContact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     *Optional receipt contact
     *
     * Generated from protobuf field <code>.io.token.proto.common.member.ReceiptContact contact = 6;</code>
     * @param \Io\Token\Proto\Common\Member\ReceiptContact $var
     * @return $this
     */
    public function setContact($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Member\ReceiptContact::class);
        $this->contact = $var;

        return $this;
    }

}

