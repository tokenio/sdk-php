<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: submission.proto

namespace Io\Token\Proto\Common\Submission;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.common.submission.StandingOrderSubmission</code>
 */
class StandingOrderSubmission extends \Google\Protobuf\Internal\Message
{
    /**
     * ID of the submission. Can be used in GetStandingOrderSubmissionRequest to fetch status.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * Bank standing order reference id: Can be used to look up StandingOrder
     *
     * Generated from protobuf field <code>string standing_order_id = 2;</code>
     */
    private $standing_order_id = '';
    /**
     * Generated from protobuf field <code>string token_id = 3;</code>
     */
    private $token_id = '';
    /**
     * Generated from protobuf field <code>int64 created_at_ms = 4;</code>
     */
    private $created_at_ms = 0;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.StandingOrderBody payload = 5;</code>
     */
    private $payload = null;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.SubmissionStatus status = 6;</code>
     */
    private $status = 0;
    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderStandingOrderSubmissionDetails provider_details = 7;</code>
     */
    private $provider_details = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           ID of the submission. Can be used in GetStandingOrderSubmissionRequest to fetch status.
     *     @type string $standing_order_id
     *           Bank standing order reference id: Can be used to look up StandingOrder
     *     @type string $token_id
     *     @type int|string $created_at_ms
     *     @type \Io\Token\Proto\Common\Token\StandingOrderBody $payload
     *     @type int $status
     *     @type \Io\Token\Proto\Common\Providerspecific\ProviderStandingOrderSubmissionDetails $provider_details
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Submission::initOnce();
        parent::__construct($data);
    }

    /**
     * ID of the submission. Can be used in GetStandingOrderSubmissionRequest to fetch status.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ID of the submission. Can be used in GetStandingOrderSubmissionRequest to fetch status.
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
     * Bank standing order reference id: Can be used to look up StandingOrder
     *
     * Generated from protobuf field <code>string standing_order_id = 2;</code>
     * @return string
     */
    public function getStandingOrderId()
    {
        return $this->standing_order_id;
    }

    /**
     * Bank standing order reference id: Can be used to look up StandingOrder
     *
     * Generated from protobuf field <code>string standing_order_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setStandingOrderId($var)
    {
        GPBUtil::checkString($var, True);
        $this->standing_order_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string token_id = 3;</code>
     * @return string
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * Generated from protobuf field <code>string token_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setTokenId($var)
    {
        GPBUtil::checkString($var, True);
        $this->token_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 created_at_ms = 4;</code>
     * @return int|string
     */
    public function getCreatedAtMs()
    {
        return $this->created_at_ms;
    }

    /**
     * Generated from protobuf field <code>int64 created_at_ms = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCreatedAtMs($var)
    {
        GPBUtil::checkInt64($var);
        $this->created_at_ms = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.StandingOrderBody payload = 5;</code>
     * @return \Io\Token\Proto\Common\Token\StandingOrderBody
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.token.StandingOrderBody payload = 5;</code>
     * @param \Io\Token\Proto\Common\Token\StandingOrderBody $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Token\StandingOrderBody::class);
        $this->payload = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.SubmissionStatus status = 6;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.SubmissionStatus status = 6;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Io\Token\Proto\Common\Submission\SubmissionStatus::class);
        $this->status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderStandingOrderSubmissionDetails provider_details = 7;</code>
     * @return \Io\Token\Proto\Common\Providerspecific\ProviderStandingOrderSubmissionDetails
     */
    public function getProviderDetails()
    {
        return $this->provider_details;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.providerspecific.ProviderStandingOrderSubmissionDetails provider_details = 7;</code>
     * @param \Io\Token\Proto\Common\Providerspecific\ProviderStandingOrderSubmissionDetails $var
     * @return $this
     */
    public function setProviderDetails($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Providerspecific\ProviderStandingOrderSubmissionDetails::class);
        $this->provider_details = $var;

        return $this;
    }

}

