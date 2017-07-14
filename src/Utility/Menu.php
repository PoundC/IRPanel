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

class Menu {

    protected static $_VisitorMenu = array();
    protected static $_SiteMenu = array();
    protected static $_UserMenu = array();
    protected static $_AdminMenu = array();

    public static function setAll($menus) {

        if(isset($menus['visitor'])) {

            self::$_VisitorMenu = $menus['visitor'];
        }

        if(isset($menus['site'])) {

            self::$_SiteMenu = $menus['site'];
        }

        if(isset($menus['user'])) {

            self::$_UserMenu = $menus['user'];
        }

        if(isset($menus['admin'])) {

            self::$_AdminMenu = $menus['admin'];
        }
    }

    public static function getVisitorMenu($currentPath) {

        $mergedArray = array_merge(self::$_VisitorMenu, self::$_SiteMenu);

        return self::buildMenu($currentPath, $mergedArray);
    }

    public static function getUserMenu($currentPath) {

        return self::buildMenu($currentPath, self::$_UserMenu);
    }

    public static function getAdminMenu($currentPath) {

        return self::buildMenu($currentPath, self::$_VisitorMenu);
    }

    public static function getIsActive($currentPath, $items) {

        foreach($items as $text => $path) {

            if(is_array($path)) {

                $isActive = self::getIsActive($currentPath, $path);

                if($isActive == true) {

                    return true;
                }
            }
            else {

                if($currentPath == $path) {

                    return true;
                }
            }
        }

        return false;
    }

    public static function isMenuActive($currentPath, $menuItems) {

        foreach($menuItems as $menuSet => $menuItem) {

            if(isset($menuItem['path']) && $currentPath == $menuItem['path']) {

                return true;
            }

            if(!isset($menuItem['path'])) {

                $isActive = self::isMenuActive($currentPath, $menuItem['menu']);

                if($isActive == true) {

                    return true;
                }
            }
        }
    }

    public static function buildMenu($currentPath, $menu) {

        $html = '<ul class="sidebar-menu" data-widget="tree">';

        foreach($menu as $headerGroup => $group) {

            $html .= '<li class="header">' . strtoupper($headerGroup) . '</li>';

            foreach ($group as $menuGroup) {

                $menuItems = $menuGroup['menu'];
                $menuName = $menuGroup['group'];
                $menuIcon = $menuGroup['icon'];

                $first_class = 'treeview';

                if(self::isMenuActive($currentPath, $menuItems) == true) {

                    $first_class .= ' active';
                }

                $html .= '<li class="' . $first_class . '"><a href="#"><i class="fa ' . $menuIcon . '"></i><span>' . $menuName . '</span>';
                $html .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
                $html .= '<ul class="treeview-menu">';

                foreach ($menuItems as $item => $items) {

                    if(isset($items['path'])) {

                        $isActive = '';

                        if($currentPath == $items['path']) {

                            $isActive = 'active';
                        }

                        $html .= '<li class="' . $isActive . '"><a href="' . $items['path'] . '"><i class="fa ' . $items['icon'] . '"></i><span>' . $item . '</span></a>';
                    }
                    else {


                        if(self::isMenuActive($currentPath, $items['menu']) == true) {

                            $first_class2 = ' active';
                        }

                        $html .= '<li class="treeview ' . $first_class2 . '"><a href="#"><i class="fa ' . $items['icon'] . '"></i><span>' . $items['group'] . '</span>';
                        $html .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
                        $html .= self::buildMenuItems($currentPath, $items['menu']);
                    }
                }

                $html .= '</ul>';
            }
        }

        $html .= '</ul>';

        return $html;
    }

    public static function buildMenuItems($currentPath, $items) {

        $html = '<ul class="treeview-menu">';

        foreach($items as $itemText => $itemSet) {

            $first_class3 = 'treeview';

            if(isset($itemSet['path'])) {

                if($currentPath == $itemSet['path']) {

                    $first_class3 .= ' active';
                }

                $html .= '<li class="' . $first_class3 . '"><a href="' . $itemSet['path'] . '"><i class="fa ' . $itemSet['icon'] . '"></i><span>' . $itemText . '</span>';
            }
            else {

                if(self::isMenuActive($currentPath, $itemSet['menu']) == true) {

                    $first_class3 .= ' active';
                }

                $html .= '<li class="' . $first_class3 . '"><a href="#"><i class="fa ' . $itemSet['icon'] . '"></i><span>' . $itemSet['group'] . '</span>';
                $html .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
                $html .= self::buildMenuItems($currentPath, $itemSet['menu']);
            }
        }

        $html .= '</ul>';

        return $html;
    }
}