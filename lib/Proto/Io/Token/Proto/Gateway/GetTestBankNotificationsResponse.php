<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gateway/gateway.proto

namespace Io\Token\Proto\Gateway;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>io.token.proto.gateway.GetTestBankNotificationsResponse</code>
 */
class GetTestBankNotificationsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * list of notifications
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.notification.Notification notifications = 1;</code>
     */
    private $notifications;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Io\Token\Proto\Common\Notification\Notification[]|\Google\Protobuf\Internal\RepeatedField $notifications
     *           list of notifications
     * }
     */
    public function __construct($data = NULL) {
        \Io\Token\GPBMetadata\Gateway\Gateway::initOnce();
        parent::__construct($data);
    }

    /**
     * list of notifications
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.notification.Notification notifications = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * list of notifications
     *
     * Generated from protobuf field <code>repeated .io.token.proto.common.notification.Notification notifications = 1;</code>
     * @param \Io\Token\Proto\Common\Notification\Notification[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setNotifications($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Io\Token\Proto\Common\Notification\Notification::class);
        $this->notifications = $arr;

        return $this;
    }

}

