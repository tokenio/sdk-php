<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: consent.proto

namespace Io\Token\Proto\Common\Consent;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.consent.Consent</code>
 */
class Consent extends \Google\Protobuf\Internal\Message
{
    /**
     * Same as the corresponding token id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.Beneficiary beneficiary = 2;</code>
     */
    private $beneficiary = null;
    /**
     * Generated from protobuf field <code>string member_id = 3;</code>
     */
    private $member_id = '';
    /**
     * ID of the member requesting consent (e.g. merchant)
     *
     * Generated from protobuf field <code>string initiator_id = 7;</code>
     */
    private $initiator_id = '';
    /**
     * Reference ID set by the member requesting consent
     *
     * Generated from protobuf field <code>string initiator_ref_id = 8;</code>
     */
    private $initiator_ref_id = '';
    protected $type;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           Same as the corresponding token id
     *     @type \Io\Token\Proto\Common\Consent\Consent\Beneficiary $beneficiary
     *     @type string $member_id
     *     @type \Io\Token\Proto\Common\Consent\Consent\InformationAccess $information_access
     *     @type \Io\Token\Proto\Common\Consent\Consent\Payment $payment
     *     @type string $initiator_id
     *           ID of the member requesting consent (e.g. merchant)
     *     @type string $initiator_ref_id
     *           Reference ID set by the member requesting consent
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Consent::initOnce();
        parent::__construct($data);
    }

    /**
     * Same as the corresponding token id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Same as the corresponding token id
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.Beneficiary beneficiary = 2;</code>
     * @return \Io\Token\Proto\Common\Consent\Consent\Beneficiary
     */
    public function getBeneficiary()
    {
        return $this->beneficiary;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.Beneficiary beneficiary = 2;</code>
     * @param \Io\Token\Proto\Common\Consent\Consent\Beneficiary $var
     * @return $this
     */
    public function setBeneficiary($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\Consent_Beneficiary::class);
        $this->beneficiary = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string member_id = 3;</code>
     * @return string
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Generated from protobuf field <code>string member_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMemberId($var)
    {
        GPBUtil::checkString($var, True);
        $this->member_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.InformationAccess information_access = 5;</code>
     * @return \Io\Token\Proto\Common\Consent\Consent\InformationAccess
     */
    public function getInformationAccess()
    {
        return $this->readOneof(5);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.InformationAccess information_access = 5;</code>
     * @param \Io\Token\Proto\Common\Consent\Consent\InformationAccess $var
     * @return $this
     */
    public function setInformationAccess($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\Consent_InformationAccess::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.Payment payment = 6;</code>
     * @return \Io\Token\Proto\Common\Consent\Consent\Payment
     */
    public function getPayment()
    {
        return $this->readOneof(6);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.consent.Consent.Payment payment = 6;</code>
     * @param \Io\Token\Proto\Common\Consent\Consent\Payment $var
     * @return $this
     */
    public function setPayment($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Consent\Consent_Payment::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * ID of the member requesting consent (e.g. merchant)
     *
     * Generated from protobuf field <code>string initiator_id = 7;</code>
     * @return string
     */
    public function getInitiatorId()
    {
        return $this->initiator_id;
    }

    /**
     * ID of the member requesting consent (e.g. merchant)
     *
     * Generated from protobuf field <code>string initiator_id = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setInitiatorId($var)
    {
        GPBUtil::checkString($var, True);
        $this->initiator_id = $var;

        return $this;
    }

    /**
     * Reference ID set by the member requesting consent
     *
     * Generated from protobuf field <code>string initiator_ref_id = 8;</code>
     * @return string
     */
    public function getInitiatorRefId()
    {
        return $this->initiator_ref_id;
    }

    /**
     * Reference ID set by the member requesting consent
     *
     * Generated from protobuf field <code>string initiator_ref_id = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setInitiatorRefId($var)
    {
        GPBUtil::checkString($var, True);
        $this->initiator_ref_id = $var;

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
