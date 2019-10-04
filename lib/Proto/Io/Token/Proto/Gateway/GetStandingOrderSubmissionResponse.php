<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetStandingOrderSubmissionResponse</code>
 */
class GetStandingOrderSubmissionResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.StandingOrderSubmission submission = 1;</code>
     */
    private $submission = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Submission\StandingOrderSubmission $submission
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.StandingOrderSubmission submission = 1;</code>
     * @return \Io\Token\Proto\Common\Submission\StandingOrderSubmission
     */
    public function getSubmission()
    {
        return $this->submission;
    }

    /**
     * Generated from protobuf field <code>.io.token.proto.common.submission.StandingOrderSubmission submission = 1;</code>
     * @param \Io\Token\Proto\Common\Submission\StandingOrderSubmission $var
     * @return $this
     */
    public function setSubmission($var)
    {
        GPBUtil::checkMessage($var, \Io\Token\Proto\Common\Submission\StandingOrderSubmission::class);
        $this->submission = $var;

        return $this;
    }

}

