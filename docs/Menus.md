# Add Menu Group
    $newMenuGroup = array(
            'type'  => 'group',
            'group' => 'Admin Menu2',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu' => [
                'Dashboard' => [
                    'path' => '/dashboard',
                    'icon' => 'fa-dashboard'
                ]
            ]
        );
    Sidebar::addMenuGroup($newMenuGroup, 'admin');       

# Add Menu to Menu Group
    $newMenu = array(
            'Whodat' => [
                'path' => '/somepath',
                'icon' => 'fa-icon'
                ]
        );
    Sidebar::addMenuToMenuGroup($newMenu, 'admin', 'Admin Menu');

# Add Sub Menu to Menu in Menu Group
    $newSubMenu = array(
            'Reporting' => [
                'path' => '/dashboard/reporting',
                'icon' => 'fa-dashboard',
                'menu' => [
                    'Reporting 2' => [
                        'path' => '/dashboard/reporting/2',
                        'icon' => 'fa-dashboard'
                    ]
                ]
            ]
        );
    Sidebar::addSubMenuToMenuInMenuGroup($newSubMenu, 'admin', 'Admin Menu', 'Dashboard');

