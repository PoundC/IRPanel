<?php

namespace AdminLTE\Utility;

use App\Utility\Tables;
use App\Utility\Vendors;
use App\Utility\Users;
use App\Utility\Dates;
use Cake\ORM\TableRegistry;

class Notifications
{
    public static $userCount;

    public static function getNotificationsTable() {

        $timelineTable = TableRegistry::get('AdminLTE.Notifications');

        return $timelineTable;
    }

    public static function addNotificationsEntry($account_id, $type, $message) {

        $table = self::getNotificationsTable();

        $entity = $table->newEntity([
            'user_id' => $account_id,
            'type' => $type,
            'message' => $message,
            'created' => new \DateTime('now')
        ]);

        $table->save($entity);
    }

    public static function getTotalCount($user_id)
    {
        if(!isset(self::$userCount)) {

            $userCount = self::getUserCount($user_id);
        }
        else {

            $userCount = self::$userCount;
        }

        return $userCount;
    }

    public static function getNavNotifications($user_id)
    {
        $notificationsArray = array();
        $notificationsTable = self::getNotificationsTable();

        $notifications = $notificationsTable->find('all', ['contain' => ['Users']])->where([
            'seen' => 0,
            'deleted' => 0,
            'user_id' => $user_id
        ])->orderDesc('notifications.created')->limit(8);

        foreach($notifications as $message)
        {
            $messageArray['type'] = $message->get('type');
            $messageArray['message'] = $message->get('message');
            $messageArray['id'] = $message->get('id');

            $notificationsArray[] = $messageArray;
        }

        return $notificationsArray;
    }

    public static function getUserCount($user_id)
    {
        if(isset(self::$userCount)) {

            return self::$userCount;
        }

        $notificationsTable = self::getNotificationsTable();

        $userCount = $notificationsTable->find('all')->where([
            'seen' => 0,
            'user_id' => $user_id,
            'deleted' => 0
        ])->count();

        self::$userCount = $userCount;

        return $userCount;
    }
}
