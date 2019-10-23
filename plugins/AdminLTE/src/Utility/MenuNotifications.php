<?php

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;

class MenuNotifications {

    const Globe = 'Global';
    const Role = 'Role';
    const User = 'User';

    public static function addGlobalGroupMenuNotification($menuGroup, $count = 1)
    {
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => '',
            'notification_count' => $count,
            'destination' => MenuNotifications::Globe,
            'user_id' => '',
            'role_id' => ''
        ]);
        $menuNotificationsTable->save($menuNotificationsEntity);
    }

    public static function addGlobalItemMenuNotification($menuGroup, $menuTitle, $count = 1)
    {
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => $menuTitle,
            'notification_count' => $count,
            'destination' => MenuNotifications::Globe,
            'user_id' => '',
            'role_id' => ''
        ]);
        $menuNotificationsTable->save($menuNotificationsEntity);
    }

    public static function addRoleGroupMenuNotification($role_id, $menuGroup, $count = 1)
    {
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => '',
            'notification_count' => $count,
            'destination' => MenuNotifications::Role,
            'user_id' => '',
            'role_id' => $role_id
        ]);
        $menuNotificationsTable->save($menuNotificationsEntity);
    }

    public static function addRoleItemMenuNotification($role_id, $menuGroup, $menuTitle, $count = 1)
    {
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => $menuTitle,
            'notification_count' => $count,
            'destination' => MenuNotifications::Role,
            'user_id' => '',
            'role_id' => $role_id
        ]);
        $menuNotificationsTable->save($menuNotificationsEntity);
    }

    public static function addUserGroupMenuNotification($user_id, $menuGroup, $count = 1)
    {
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => '',
            'notification_count' => $count,
            'destination' => MenuNotifications::User,
            'user_id' => $user_id,
            'role_id' => ''
        ]);
        $menuNotificationsTable->save($menuNotificationsEntity);
    }

    public static function addUserItemMenuNotification($user_id, $menuGroup, $menuTitle, $count = 1)
    {
        // die($user_id);
        $menuNotificationsTable = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationsEntity = $menuNotificationsTable->newEntity([
            'menu_group' => $menuGroup,
            'menu_title' => $menuTitle,
            'notification_count' => $count,
            'destination' => MenuNotifications::User,
            'user_id' => $user_id,
            'role_id' => ''
        ]);
        die(print_r(debug($menuNotificationsEntity), true));
        $menuNotificationsTable->save($menuNotificationsEntity);

    }

    public static function markMenuNotificationsSeen($user_id, $role, $menuGroup, $menuTitle = '')
    {
        $menuNotifications = TableRegistry::get('AdminLTE.AdminLTEMenuNotifications');
        $menuNotificationLogs = TableRegistry::get('AdminLTE.AdminLTEMenuNotificationLogs');

        if($menuTitle == '') {

            $linkNotifications = $menuNotifications->find('all', ['contain' => 'AdminLTEMenuNotificationLogs'])
                ->where([
                    'OR' => [
                        ['destination' => 'User', 'AdminLTEMenuNotifications.user_id' => $user_id],
                        ['destination' => 'Global'],
                        ['destination' => 'Role', 'role_id' => $role],
                    ],
                    // Common conditions
                    'menu_group' => $menuGroup
                ]);
        }
        else {

            $linkNotifications = $menuNotifications->find('all', ['contain' => 'AdminLTEMenuNotificationLogs'])
                ->where([
                    'OR' => [
                        ['destination' => 'User', 'AdminLTEMenuNotifications.user_id' => $user_id],
                        ['destination' => 'Global'],
                        ['destination' => 'Role', 'role_id' => $role],
                    ],
                    // Common conditions
                    'menu_title' => $menuTitle,
                    'menu_group' => $menuGroup
                ]);
        }

        $linkNotifications->notMatching('AdminLTEMenuNotificationLogs', function (\Cake\ORM\Query $query) use($user_id) {
            return $query->where(['AdminLTEMenuNotificationLogs.user_id' => $user_id]);
        });
        $linkNotificationsResults = $linkNotifications->all();

        foreach($linkNotificationsResults as $linkNotificationsResult)
        {
            $logEntity = $menuNotificationLogs->newEntity([
                'admin_l_t_e_menu_notification_id' => $linkNotificationsResult->id,
                'user_id' => $user_id,
                'created' => new \DateTime('now')
            ]);

            $menuNotificationLogs->save($logEntity);
        }
    }
}
