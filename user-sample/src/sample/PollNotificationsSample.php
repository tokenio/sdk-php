<?php
namespace Tokenio\Sample\User;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Alias\Alias\Type;
use Io\Token\Proto\Common\Notification\Notification;
use Io\Token\Proto\Common\Notification\NotifyBody;
use Tokenio\User\Member;
use Tokenio\Util\Strings;
use const Io\Token\Proto\Common\Notification\NotifyStatus;
use const Io\Token\Proto\Common\Notification\PayeeTransferProcessed;

class PollNotificationsSample
{
    /**
     * @param $tokenClient \Tokenio\User\TokenClient
     * @return Member
     * @throws \Exception
     */
    public static function createMember($tokenClient)
    {
        $alias = new Alias();
        $alias->setType(Type::EMAIL)
            ->setValue("test-". strtolower(Strings::generateNonce())."+noverify@example.com");

        $member = $tokenClient->createMember($alias);
        $member->subscribeToNotifications("iron");
        return $member;
    }

    /**
     * @param $member Member
     * @return bool|null
     * @throws \Exception
     */
    public static function poll($member)
    {
        for($retries=0; $retries < 5; $retries ++)
        {
            $pagedList = $member->getNotifications(null, 10);

            /* @var $notifications Notification[] */
            $notifications = $pagedList->getList();

            if(!empty($notifications))
            {
                $notification = $notifications[0];

                switch($notification->getContent()->getType()){
                    case 'PAYEE_TRANSFER_PROCESSED':
                        sprintf("Transfer processed: %s", $notification->serializeToJsonString());
                        break;

                    default:
                        sprintf("Got notification: %s", $notification->serializeToJsonString());
                        break;
                }
                return ($notification != null)? true: false;
            }
            try {
                sprintf("Don't see notifications yet. Sleeping...");
                sleep(1);
            }
            catch (Exception $ie){
                throw new \RuntimeException($ie);
            }
        }
        return null;
    }
}