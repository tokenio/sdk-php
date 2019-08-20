<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: notification.proto

namespace Io\Token\Proto\Common\Notification;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A notification to indicate that a previously sent notification was invalidated
 *
 * Generated from protobuf message <code>io.token.proto.common.notification.NotificationInvalidated</code>
 */
class NotificationInvalidated extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string previous_notification_id = 1;</code>
     */
    private $previous_notification_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $previous_notification_id
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Notification::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string previous_notification_id = 1;</code>
     * @return string
     */
    public function getPreviousNotificationId()
    {
        return $this->previous_notification_id;
    }

    /**
     * Generated from protobuf field <code>string previous_notification_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setPreviousNotificationId($var)
    {
        GPBUtil::checkString($var, True);
        $this->previous_notification_id = $var;

        return $this;
    }

}

