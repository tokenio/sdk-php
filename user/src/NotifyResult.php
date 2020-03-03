<?php

namespace Tokenio\User;


use Io\Token\Proto\Common\Notification\NotifyStatus;

class NotifyResult
{

    /* @var $notificationId string */
    private $notificationId;

    /* @var $notifyStatus NotifyStatus */
    private $notifyStatus;

    public function __construct($notificationId, $notifyStatus)
    {
        $this->notificationId = $notificationId;
        $this->notifyStatus = $notifyStatus;
    }

    public function create($notificationId, $notifyStatus)
    {
        return new NotifyResult($notificationId, $notifyStatus);
    }

    /**
     * @return string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * @return NotifyStatus
     */
    public function getNotifyStatus()
    {
        return $this->notifyStatus;
    }

}