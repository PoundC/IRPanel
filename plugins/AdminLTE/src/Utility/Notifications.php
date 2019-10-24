<?php

namespace AdminLTE\Utility;

use App\Utility\Tables;
use App\Utility\Vendors;
use App\Utility\Users;
use App\Utility\Dates;
use Cake\ORM\TableRegistry;

class Notifications
{
    const Globe = 'Global';
    const Role = 'Role';
    const User = 'User';

    const Message = 'fa fa-envelope';
    const NewUser = 'fa fa-user';
    const Alert = 'fa fa-warning';

    public static $userCount;

    public static function getNotificationsTable() {

        return TableRegistry::get('AdminLTE.Notifications');
    }

    public static function getNotificationLogsTable() {

        return TableRegistry::get('AdminLTE.AdminLTENotificationLogs');
    }

    public static function getPushNotificationsTable() {

        return TableRegistry::get('AdminLTE.AdminLTEPushNotifications');
    }

    public static function addGlobalNotificationsEntry($type, $message, $color = 'Success', $link = '') {

        self::addNotificationsEntry(self::Globe, '', '', $type, $message, $color, $link);
    }

    public static function addRoleNotificationsEntry($role_id, $type, $message, $color = 'Success', $link = '') {

        self::addNotificationsEntry(self::Role, '', $role_id, $type, $message, $color, $link);
    }

    public static function addUserNotificationsEntry($user_id, $type, $message, $color = 'Success', $link = '') {

        self::addNotificationsEntry(self::User, $user_id, '', $type, $message, $color, $link);
    }

    public static function addNotificationsEntry($destination, $user_id, $role_id, $type, $message, $color = 'Success', $link = '') {

        $table = self::getNotificationsTable();

        $entity = $table->newEntity([
            'destination' => $destination,
            'user_id' => $user_id,
            'role_id' => $role_id,
            'type' => $type,
            'message' => $message,
            'color' => $color,
            'link' => $link,
            'created' => new \DateTime('now')
        ]);

        $table->save($entity);

        if($type != 'fa fa-envelope') {

            MenuNotifications::addUserItemMenuNotification($user_id, 'Notifications', 'Notifications');
        }
    }

    public static function markNotificationsCountSeen($user_id, $role_id)
    {
        $notificationLogsTable = self::getNotificationLogsTable();

        $userCountQuery = self::getNotificationsQuery($user_id, $role_id);

        $userNotifications = $userCountQuery->all();

        foreach($userNotifications as $userNotification)
        {
            $notificationId = $userNotification->id;

            $notificationLogEntity = $notificationLogsTable->newEntity([
                'notification_id' => $notificationId,
                'user_id' => $user_id,
                'created' => new \DateTime('now')
            ]);
            $notificationLogsTable->save($notificationLogEntity);
        }
    }

    public static function getPushNotifications($user_id, $role_id)
    {
        $pushNotificationsTable = self::getPushNotificationsTable();
        $notificationsTable = self::getNotificationsTable();

        $userCountQuery = $notificationsTable->find('all', ['contain' => 'AdminLTEPushNotifications']);
        $userCountQuery->where([
            'OR' => [
                ['destination' => 'User', 'Notifications.user_id' => $user_id],
                ['destination' => 'Role', 'Notifications.role_id' => $role_id],
                ['destination' => 'Global']
            ]
        ])
        ->notMatching('AdminLTEPushNotifications', function (\Cake\ORM\Query $query) use ($user_id) {
            return $query->where(['AdminLTEPushNotifications.user_id' => $user_id]);
        });

        $pushNotifications = $userCountQuery->all();

        foreach($pushNotifications as $pushNotification)
        {
            $notificationId = $pushNotification->id;

            $notificationLogEntity = $pushNotificationsTable->newEntity([
                'notification_id' => $notificationId,
                'user_id' => $user_id,
                'created' => new \DateTime('now')
            ]);
            $pushNotificationsTable->save($notificationLogEntity);
        }

        return $pushNotifications;
    }

    public static function getNotificationsQuery($user_id, $role_id)
    {
        $notificationsTable = self::getNotificationsTable();
        $userCountQuery = $notificationsTable->find('all', ['contain' => 'AdminLTENotificationLogs']);
        $userCountQuery->where([
                'OR' => [
                    ['destination' => 'User', 'Notifications.user_id' => $user_id],
                    ['destination' => 'Role', 'Notifications.role_id' => $role_id],
                    ['destination' => 'Global']
                ]
            ])
            ->notMatching('AdminLTENotificationLogs', function (\Cake\ORM\Query $query) use ($user_id) {
                return $query->where(['AdminLTENotificationLogs.user_id' => $user_id]);
            });

        return $userCountQuery;
    }

    public static function getNotificationsCountQuery($user_id, $role_id)
    {
        $notificationsTable = self::getNotificationsTable();
        $userCountQuery = $notificationsTable->find('all', ['contain' => 'AdminLTENotificationLogs']);
        $userCountQuery->select(['total' => $userCountQuery->func()->sum('total_count')])
            ->where([
                'OR' => [
                    ['destination' => 'User', 'Notifications.user_id' => $user_id],
                    ['destination' => 'Role', 'Notifications.role_id' => $role_id],
                    ['destination' => 'Global']
                ]
            ])
            ->notMatching('AdminLTENotificationLogs', function (\Cake\ORM\Query $query) use ($user_id) {
                return $query->where(['AdminLTENotificationLogs.user_id' => $user_id]);
            });

        return $userCountQuery;
    }

    public static function getTotalCount($user_id, $role_id)
    {
        if(!isset(self::$userCount)) {

            $userCount = self::getUserCount($user_id, $role_id);
        }
        else {

            $userCount = self::$userCount;
        }

        return $userCount;
    }

    public static function getNavNotifications($user_id, $role_id)
    {
        $notificationsArray = array();
        $notificationsTable = self::getNotificationsTable();

        $notifications = $notificationsTable->find('all', ['contain' => ['Users']])->where([
            'OR' => [
                ['user_id' => $user_id],
                ['role_id' => $role_id],
                ['destination' => self::Globe]
            ]
        ])->orderDesc('notifications.created')->limit(8);

        foreach($notifications as $message)
        {
            $messageArray['type'] = $message->get('type');
            $messageArray['message'] = $message->get('message');
            $messageArray['id'] = $message->get('id');
            $messageArray['link'] = $message->get('link');

            $notificationsArray[] = $messageArray;
        }

        return $notificationsArray;
    }

    public static function getUserCount($user_id, $role_id)
    {
        if(isset(self::$userCount)) {

            return self::$userCount;
        }

        $userCountQuery = self::getNotificationsCountQuery($user_id, $role_id)->first();

        self::$userCount = $userCountQuery->total;

        return self::$userCount;
    }
}
