<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/21/17
 * Time: 5:47 PM
 */

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;

class Sidebar
{
    public static $Menu = array();

    public static function setMenu($menuArray)
    {
        if(count(self::$Menu) == 0) {

            self::$Menu = $menuArray;
        }
        else {

            self::$Menu = array_merge_recursive(self::$Menu, $menuArray);
            //self::$Menu = Menu::mergeMenus(self::$Menu, $menuArray);

            //print_r(self::$Menu);
        }
    }

    public static function addMenuGroup($menu, $role)
    {
        Sidebar::$Menu[$role][] = $menu;
    }

    public static function addMenuToMenuGroup($menu, $role, $menuGroupTitle)
    {
        for($x = 0; $x < count(Sidebar::$Menu[$role]); $x++) {

            if(Sidebar::$Menu[$role][$x]['type'] == 'group' && Sidebar::$Menu[$role][$x]['group'] == $menuGroupTitle) {

                foreach($menu as $title => $menuSet) {

                    Sidebar::$Menu[$role][$x]['menu'][$title] = $menuSet;
                }
            }
        }
    }

    public static function addSubMenuToMenuInMenuGroup($menu, $role, $menuGroupTitle, $menuTitle)
    {
        for($x = 0; $x < count(Sidebar::$Menu[$role]); $x++) {

            if(Sidebar::$Menu[$role][$x]['type'] == 'group' && Sidebar::$Menu[$role][$x]['group'] == $menuGroupTitle) {

                Sidebar::$Menu[$role][$x]['menu'][$menuTitle]['menu'] = $menu;
            }
        }
    }

    public static function buildMenu($currentPath, $role = 'visitor', $user_id = 0, $addUl = true, $addSite = true)
    {
        if($addUl == true) {

            $menuHtml = '<ul id="nav-menu" class="sidebar-menu" data-widget="tree">' . "\n";
        } else {

            $menuHtml = '';
        }

        foreach(Sidebar::$Menu[$role] as $menuKey => $menuItem)
        {
            switch ($menuItem['type']) {
                case 'header':
                    $menuHtml .= Sidebar::buildHeader($menuItem);
                    break;
                case 'link':
                    $menuHtml .= Sidebar::buildLink($currentPath, $menuItem, $role, $user_id);
                    break;
                case 'group':
                    $menuHtml .= Sidebar::buildGroup($currentPath, $menuItem, $role, $user_id);
                    break;
            }
        }

        if($addSite == true) {

            $menuHtml .= Sidebar::buildMenu($currentPath, 'site', $user_id, false, false);
        }

        if($addUl == true) {

            $menuHtml .= '</ul>';
        }

        return $menuHtml;
    }

    private static function buildHeader($menuItem)
    {
        $header = '<li class="header">' . strtoupper($menuItem['header']) . '</li>' . "\n";

        return $header;
    }

    private static function buildLink($currentPath, $menuItem, $role, $user_id)
    {
        $menuNotifications = MenuNotifications::getMenuNotificationsTable();
        $linkNotifications = $menuNotifications->find('all', ['contain' => 'AdminLTEMenuNotificationLogs']);
        $linkNotifications->select(['total' => $linkNotifications->func()->sum('notification_count')])
            ->where([
                'OR' => [
                    ['destination' => 'User', 'MenuNotifications.user_id' => $user_id],
                    ['destination' => 'Global'],
                    ['destination' => 'Role', 'role_id' => $role],
                ],
                // Common conditions
                'menu_title' => $menuItem['link'],
                'menu_group' => $menuItem['link']
            ]);
        $linkNotifications->notMatching('AdminLTEMenuNotificationLogs', function (\Cake\ORM\Query $query) use($user_id) {
            return $query->where(['AdminLTEMenuNotificationLogs.user_id' => $user_id]);
        });
        $linkNotificationsResult = $linkNotifications->first();
        $linkNotificationsResultTotal = $linkNotificationsResult->total;

        $isActive = '';

        if ($currentPath == $menuItem['path']) {

            $isActive = 'class="active"';
        }

        $link = '<li ' . $isActive . '><a href="' . $menuItem['path'] . '"><i class="fa-left-icon fa ' . $menuItem['icon'] . '"></i><span>' . $menuItem['link'] . '</span><span class="pull-right-container"><small class="label pull-right bg-green">' . $linkNotificationsResultTotal . '</small></span></a></li>' . "\n";

        return $link;
    }

    private static function buildGroup($currentPath, $menuItem, $role, $user_id)
    {
        $menuNotifications = MenuNotifications::getMenuNotificationsTable();
        $groupNotifications = $menuNotifications->find('all', ['contain' => 'AdminLTEMenuNotificationLogs']);
        $groupNotifications->select(['total' => $groupNotifications->func()->sum('notification_count')])
            ->where([
                'OR' => [
                    ['destination' => 'User', 'MenuNotifications.user_id' => $user_id],
                    ['destination' => 'Global'],
                    ['destination' => 'Role', 'role_id' => $role],
                ],
                // Common conditions
                'menu_group' => $menuItem['group']
            ]);
        $groupNotifications->notMatching('AdminLTEMenuNotificationLogs', function (\Cake\ORM\Query $query) use($user_id) {
            return $query->where(['AdminLTEMenuNotificationLogs.user_id' => $user_id]);
        });
        $groupNotificationsResult = $groupNotifications->first();
        $groupNotificationsResultTotal = $groupNotificationsResult->total;

        if (Sidebar::isMenuActive($currentPath, $menuItem['menu'])) {

            $second_class = 'active';
            $isActive = 'active';
        } else {

            $second_class = 'non-active';
            $isActive = $menuItem['css'];
        }

        if (Sidebar::doesMenuContainSubMenus($menuItem['menu'])) {

            $isActive .= ' treeview';
        }

        $isActive .= ' treeview';

        $group = '';
        if (isset($menuItem['path'])) {

            $group .= '<li class="' . $isActive . '"><a href="' . $menuItem['path'] . '"><i class="fa-left-icon fa ' . $menuItem['icon'] . ' ' . $second_class . '"></i><span class="' . $second_class . '">' . $menuItem['group'] . '</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>' . "\n";
        }
        else {

            $group .= '<li class="' . $isActive . '"><a href="#"><i class="fa-left-icon fa ' . $menuItem['icon'] . ' ' . $second_class . '"></i><span class="' . $second_class . '">' . $menuItem['group'] . '</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>' . "\n";
        }
        $group .= '<span class="pull-right-container"><small class="label pull-right bg-green">' . $groupNotificationsResultTotal . '</small></span></a>' . "\n";
        $group .= '<ul class="treeview-menu">' . "\n";

        foreach ($menuItem['menu'] as $item => $items) {

            $itemNotifications = $menuNotifications->find('all', ['contain' => 'AdminLTEMenuNotificationLogs']);
            $itemNotifications->select(['total' => $itemNotifications->func()->sum('notification_count')])
                ->where([
                    'OR' => [
                        ['destination' => 'User', 'MenuNotifications.user_id' => $user_id],
                        ['destination' => 'Global'],
                        ['destination' => 'Role', 'role_id' => $role],
                    ],
                    // Common conditions
                    'menu_title' => $item,
                    'menu_group' => $menuItem['group']
                ]);
            $itemNotifications->notMatching('AdminLTEMenuNotificationLogs', function (\Cake\ORM\Query $query) use($user_id) {
                return $query->where(['AdminLTEMenuNotificationLogs.user_id' => $user_id]);
            });
            $itemNotificationsResult = $itemNotifications->first();
            $itemNotificationsResultTotal = $itemNotificationsResult->total;

            $menuTitle = $item;
            $menuPath = $items['path'];
            $menuIcon = $items['icon'];

            $isActive = '';

            if(isset($items['menu'])) {

                $isActive .= 'treeview';
            }

            if ($currentPath == $items['path']) {

                $isActive = ' active';
            }

            if(isset($items['menu']))
            {
                $group .= '<li class="' . $isActive . '"><a href="' . $menuPath . '"><i class="fa-left-icon fa ' . $menuIcon . '"></i><span>' . $menuTitle . '</span><span class="pull-right-container"><small class="label pull-right bg-green">' . $itemNotificationsResultTotal . '</small></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>' . "\n";
            }
            else {

                $group .= '<li class="' . $isActive . '"><a href="' . $menuPath . '"><i class="fa-left-icon fa ' . $menuIcon . '"></i><span>' . $menuTitle . '</span><span class="pull-right-container"><small class="label pull-right bg-green">' . $itemNotificationsResultTotal . '</small></span></a>' . "\n";
            }

            if(isset($items['menu'])) {

                $group .= Sidebar::buildSubMenus($currentPath, $items);
            }

            $group .= '</li>' . "\n";
        }

        $group .= '</ul></li>' . "\n";

        return $group;
    }

    private static function buildSubMenus($currentPath, $menuItems)
    {
        $isActive = '';

        $subMenu = '<ul class="treeview-menu">' . "\n";

        foreach($menuItems['menu'] as $itemKey => $itemValue) {

            if($currentPath == $itemValue['path']) {

                $isActive .= ' active';
            }

            $menuTitle = $itemKey;
            $menuPath = $itemValue['path'];
            $menuIcon = $itemValue['icon'];

            $subMenu .= '<li class="' . $isActive . '"><a href="' . $menuPath . '"><i class="fa-left-icon fa ' . $menuIcon . '"></i><span>' . $menuTitle . '</span></a>' . "\n";

            if(isset($itemValue['menu']) && $currentPath == $itemValue['path']) {

                $subMenu .= Sidebar::buildSubMenus($currentPath, $itemValue);
            }

            $subMenu .= '</li>' . "\n";
        }

        $subMenu .= '</ul>' . "\n";

        return $subMenu;
    }

    private static function doesMenuContainSubMenus($menuItems)
    {
        foreach($menuItems as $menuTitle => $menuValues) {

            if(isset($menuValues['menu'])) {

                return true;
            }
        }
    }

    private static function isMenuActive($currentPath, $menuItems)
    {
        foreach ($menuItems as $menuSet => $menuItem) {

            if (isset($menuItem['path']) && $currentPath == $menuItem['path']) {

                return true;
            }

            if (isset($menuItem['menu'])) {

                $isActive = self::isMenuActive($currentPath, $menuItem['menu']);

                if ($isActive == true) {

                    return true;
                }
            }
        }
    }
}
