<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 6/23/17
 * Time: 1:37 AM
 */

namespace App\Utility;

/*
 * Menu Template
 *
 *   <li class="treeview">
 *       <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
 *           <span class="pull-right-container">
 *               <i class="fa fa-angle-left pull-right"></i>
 *           </span>
 *       </a>
 *       <ul class="treeview-menu">
 *           <li><a href="#">Link in level 2</a></li>
 *           <li><a href="#">Link in level 2</a></li>
 *       </ul>
 *   </li>
 *
 */

/*
 * Menu Array Template
 *
 * $menus = [
 *      'visitor' => [
 *           'Site Links' => [
 *               'Home' => [
 *                   'Some Link' => '/',
 */

class Menu
{

    protected static $_VisitorMenu = array();
    protected static $_SiteMenu = array();
    protected static $_UserMenu = array();
    protected static $_AdminMenu = array();
    protected static $_MemberMenu = array();

    public static function setAll($menus)
    {
        if (isset($menus['visitor'])) {

            self::$_VisitorMenu = $menus['visitor'];
        }

        if (isset($menus['site'])) {

            self::$_SiteMenu = $menus['site'];
        }

        if (isset($menus['user'])) {

            self::$_UserMenu = $menus['user'];
        }

        if(isset($menus['member'])) {

            self::$_MemberMenu = $menus['member'];
        }

        if (isset($menus['admin'])) {

            self::$_AdminMenu = $menus['admin'];
        }
    }

    public static function getVisitorMenu($currentPath)
    {
        $mergedArray = array_merge(self::$_VisitorMenu, self::$_SiteMenu);

        return self::buildMenu($currentPath, $mergedArray);
    }

    public static function getUserMenu($currentPath)
    {
        $mergedArray = array_merge(self::$_UserMenu, self::$_SiteMenu);

        return self::buildMenu($currentPath, $mergedArray);
    }

    public static function getMemberMenu($currentPath)
    {
        $mergedArray = array_merge(self::$_MemberMenu, self::$_SiteMenu);

//        $mergedArray = self::mergeMenus(self::$_UserMenu, $mergedArray);

        return self::buildMenu($currentPath, $mergedArray);
    }

    public static function getAdminMenu($currentPath)
    {
        return self::buildMenu($currentPath, self::$_AdminMenu);
    }

    public static function mergeMenus($menu1, $menu2)
    {
        $mergedMenu = array();

        foreach($menu1 as $menuHeader1 => $headerArray1) {

            $mergedMenu[$menuHeader1] = $headerArray1;

            foreach($menu2 as $menuHeader2 => $headerArray2) {

                if($menuHeader1 == $menuHeader2) {

                    $mergedMenu[$menuHeader1] = array_merge($mergedMenu[$menuHeader1], $headerArray2);
                }
                else {

                    $mergedMenu[$menuHeader2] = $headerArray2;
                }
            }
        }

        $cleanMenus = array();
        $menuSets = array();

        foreach($mergedMenu as $menuHeader => $menuArray) {

            $cleanMenus[$menuHeader] = array();

            foreach($menuArray as $menuIndex => $menuSet) {

                if(array_key_exists('group',$menuSet)) {

                    if (array_key_exists($menuSet['group'], $cleanMenus[$menuHeader])) {

                        $mergedMenus = array_merge($menuSet, $cleanMenus[$menuHeader][$menuSet['group']]);

                        $cleanMenus[$menuHeader][$menuSet['group']]['set'] = $mergedMenus;

                        $mergedMenus = array_merge($menuSet['menu'], $cleanMenus[$menuHeader][$menuSet['group']]['menu']);

                        $cleanMenus[$menuHeader][$menuSet['group']]['menu'] = $mergedMenus;
                    } else {

                        $cleanMenus[$menuHeader][$menuSet['group']]['set'] = $menuSet;
                        $cleanMenus[$menuHeader][$menuSet['group']]['menu'] = $menuSet['menu'];
                    }
                }
                else {


                }
            }
        }

        $rebuiltMenus = array();
        $groupsComplete = array();

        foreach($mergedMenu as $menuHeader => $menuArray) {

            $rebuiltMenus[$menuHeader] = array();

            foreach($menuArray as $menuSet) {

                if(isset($menuSet['group'])) {

                    $cleanSet = $cleanMenus[$menuHeader][$menuSet['group']]['set'];
                    $cleanMenu = $cleanMenus[$menuHeader][$menuSet['group']]['menu'];
                    $cleanSet['menu'] = $cleanMenu;
                    unset($cleanSet['set']);

                    $rebuiltMenus[$menuHeader][] = $cleanSet;
                }
                else {

                    $rebuiltMenus[$menuHeader][] = $menuSet;
                }
            }
        }

        $servableMenus = array();

        foreach($rebuiltMenus as $menuHeader => $menuArray) {

            $bFoundMenu = false;
            foreach($menuArray as $menuSet) {

                foreach ($servableMenus as $menuHeader2 => $menuArray2) {

                    foreach($menuArray2 as $menuSet2) {

                        if(isset($menuSet2['group']) && isset($menuSet['group'])) {

                            if ($menuSet['group'] == $menuSet2['group']) {

                                $bFoundMenu = true;
                                break;
                            }
                        }
                    }
                }

                if ($bFoundMenu == false) {

                    $servableMenus[$menuHeader][] = $menuSet;
                }
            }
        }

        return $servableMenus;
    }

    public static function mergeSubMenus($menu1, $menu2)
    {

    }

    public static function getIsActive($currentPath, $items)
    {

        foreach ($items as $text => $path) {

            if (is_array($path)) {

                $isActive = self::getIsActive($currentPath, $path);

                if ($isActive == true) {

                    return true;
                }
            } else {

                if ($currentPath == $path) {

                    return true;
                }
            }
        }

        return false;
    }

    public static function isMenuActive($currentPath, $menuItems)
    {

        foreach ($menuItems as $menuSet => $menuItem) {

            if (isset($menuItem['path']) && $currentPath == $menuItem['path']) {

                return true;
            }

            if (!isset($menuItem['path'])) {

                $isActive = self::isMenuActive($currentPath, $menuItem['menu']);

                if ($isActive == true) {

                    return true;
                }
            }
        }
    }

    public static function buildMenu($currentPath, $menu)
    {

        $html = '<ul id="nav-menu" class="sidebar-menu" data-api="tree" data-accordion=1 data-widget="tree">';

        foreach ($menu as $headerGroup => $group) {

            if($headerGroup != 'blank') {

                $html .= '<li class="header">' . strtoupper($headerGroup) . '</li>';
            }

            foreach ($group as $menuGroup) {

                if (isset($menuGroup['group'])) {
                    $menuItems = $menuGroup['menu'];
                    $menuName = $menuGroup['group'];
                    $menuIcon = $menuGroup['icon'];

                    $first_class = 'treeview';
                    $second_class = '';
                    $is_active = false;

                    if (self::isMenuActive($currentPath, $menuItems) == true) {

                        $is_active = true;
                        $first_class .= ' active';
                    }

                    if (isset($menuGroup['css'])) {

                        $first_class .= ' ' . $menuGroup['css'];

                        if (strpos($first_class, 'non-active') > -1) {

                            if($is_active == false) {

                                $second_class = 'non-active';
                            }
                        }
                    }

                    $html .= '<li class="' . $first_class . '"><a href="#"><i class="fa-left-icon fa ' . $menuIcon . ' ' . $second_class . '"></i><span class="' . $second_class . '">' . $menuName . '</span>';
                    $html .= '<span class="pull-right-container"></span></a>';
                    $html .= '<ul class="treeview-menu">';

                    foreach ($menuItems as $item => $items) {

                        if (isset($items['path'])) {

                            $isActive = '';

                            if ($currentPath == $items['path']) {

                                $isActive = 'active';
                            }

                            $html .= '<li class="' . $isActive . '"><a href="' . $items['path'] . '"><i class="fa-left-icon fa ' . $items['icon'] . '"></i><span>' . $item . '</span></a>';
                        } else {

                            $first_class2 = 'treeview';
                            $second_class2 = '';
                            $is_active2 = false;

                            if (self::isMenuActive($currentPath, $items['menu']) == true) {

                                $is_active2 = true;
                                $first_class2 = ' active';
                            }

                            if (strpos($first_class2, 'active') < 0 && isset($items['css'])) {

                                $first_class2 .= ' ' . $items['css'];

                                if (strpos($first_class2, 'non-active') > -1) {

                                    if($is_active2 == false) {
                                        $second_class2 = 'non-active';
                                    }
                                }
                            }

                            $html .= '<li class="' . $first_class2 . '"><a href="#"><i class="fa-left-icon fa ' . $items['icon'] . ' ' . $second_class2 . '"></i><span class="' . $second_class2 . '">' . $items['group'] . '</span>';
                            $html .= '<span class="pull-right-container"></span></a>';
                            $html .= self::buildMenuItems($currentPath, $items['menu']);
                        }
                    }

                    $html .= '</ul>';
                } else if (isset($menuGroup['link'])) {

                    $isActive = '';

                    if ($currentPath == $menuGroup['path']) {

                        $isActive = 'class="active"';
                    }

                    $html .= '<li ' . $isActive . '><a href="' . $menuGroup['path'] . '"><i class="fa-left-icon fa ' . $menuGroup['icon'] . '"></i><span>' . $menuGroup['link'] . '</span></a>';
                }
            }
        }

        $html .= '</ul>';

        return $html;
    }

    public static function buildMenuItems($currentPath, $items)
    {

        $html = '<ul class="treeview-menu">';

        foreach ($items as $itemText => $itemSet) {

            $first_class3 = 'treeview';
            $second_class3 = '';
            $is_active3 = false;

            if (isset($items['css'])) {

                $first_class3 .= ' ' . $itemSet['css'];

                if (strpos($first_class3, 'non-active') > -1) {

                    $second_class3 = 'non-active';
                }
            }

            if (isset($itemSet['path'])) {

                if ($currentPath == $itemSet['path']) {

                    $first_class3 .= ' active';
                }

                $html .= '<li class="' . $first_class3 . '"><a href="' . $itemSet['path'] . '"><i class="fa-left-icon fa ' . $itemSet['icon'] . '"></i><span>' . $itemText . '</span></a>';
            } else {

                if (self::isMenuActive($currentPath, $itemSet['menu']) == true) {

                    $is_active3 = true;
                    $first_class3 .= ' active';
                }

                if (strpos($first_class3, 'active') < 0 && isset($itemSet['css'])) {

                    $first_class3 .= ' ' . $itemSet['css'];

                    if (strpos($first_class3, 'non-active') > -1) {

                        if($is_active3 == false) {

                            $second_class3 = 'non-active';
                        }
                    }
                }

                $html .= '<li class="' . $first_class3 . '"><a href="#"><i class="fa-left-icon fa ' . $itemSet['icon'] . ' ' . $second_class3 . '"></i><span class="' . $second_class3 . '">' . $itemSet['group'] . '</span>';
                $html .= '<span class="pull-right-container"></span></a>';
                $html .= self::buildMenuItems($currentPath, $itemSet['menu']);
            }
        }

        $html .= '</ul>';

        return $html;
    }
}