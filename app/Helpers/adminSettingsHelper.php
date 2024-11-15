<?php
namespace App\Helpers;

class adminSettingsHelper {

    public static function getSidebarMenu() {

        $menu = array(
            array(
                'title' => 'Store',
                'url' => '',
                'icon' => 'ki-basket',
                'roles' => ['admin', 'manager'],
                'childs' => array(
                    array(
                        'title' => 'Products',
                        'url' => route('dashboard.products.index'),
                        'roles' => ['admin', 'manager'],
                    ),
                    array(
                        'title' => 'Orders',
                        'url' => route('dashboard.orders.index'),
                        'roles' => ['admin', 'manager'],
                    ),
                    array(
                        'title' => 'Payment gateways',
                        'url' => route('dashboard.gateways.index'),
                        'roles' => ['admin'],
                    ),
                ),
            ),
            array(
                'title' => 'Content',
                'url' => '',
                'icon' => 'ki-file',
                'roles' => ['admin', 'manager'],
                'childs' => array(
                    /*array(
                        'title' => 'Articles',
                        'url' => route('dashboard.articles.index'),
                        'roles' => ['admin', 'manager'],
                    ),*/
                    array(
                        'title' => 'Countries',
                        'url' => route('dashboard.countries.index'),
                        'roles' => ['admin', 'manager'],
                    ),
                    array(
                        'title' => 'Travel Directions',
                        'url' => route('dashboard.directions.index'),
                        'roles' => ['admin', 'manager'],
                    ),
                ),
            ),
            array(
                'title' => 'Settings',
                'url' => route('dashboard.settings.index'),
                'icon' => 'ki-element-11',
                'roles' => ['admin'],
                'childs' => array(
                    array(
                        'title' => 'General',
                        'url' => route('dashboard.settings.index'),
                        'roles' => ['admin'],
                    ),
                    array(
                        'title' => 'Users',
                        'url' => route('dashboard.users.index'),
                        'roles' => ['admin'],
                    ),
                ),

            ),
            array(
                'title' => 'My cabinet',
                'url' => '',
                'icon' => 'ki-user',
                'roles' => ['user'],
                'childs' => array(
                    array(
                        'title' => 'Profile',
                        'url' => route('dashboard.profile'),
                        'roles' => ['user'],
                    ),
                    array(
                        'title' => 'Orders',
                        'url' => route('dashboard.my-orders'),
                        'roles' => ['user'],
                    ),
                ),
            ),
        );

        // Filter menu by user role
        $menu = self::filterMenuByRole($menu);

        // Set active menus
        $menu = self::setActiveMenus($menu);

        return $menu;

    }

    public static function filterMenuByRole( $menu ) {

        $user = auth()->user();
        $menu = array_filter($menu, function($item) use ($user) {
            if (isset($item['roles'])) {
                if (in_array($user->getRole()->slug, $item['roles'])) {
                    return true;
                }
            } else {
                return true;
            }
        });

        return $menu;

    }

    public static function setActiveMenus( $menu ) {

        // Lets mark active menus using routes data
        foreach ($menu as $key => $item) {
            if (isset($item['childs'])) {
                foreach ($item['childs'] as $key2 => $item2) {
                    if ( strpos(request()->url(), $item2['url']) !== false ) {
                        $menu[$key]['active'] = true;
                        $menu[$key]['childs'][$key2]['active'] = true;
                    } else {
                        $menu[$key]['active'] = true;
                        $menu[$key]['childs'][$key2]['active'] = false;
                    }
                }
            } else {
                if ( strpos(request()->url(), $item['url']) !== false ) {
                    $menu[$key]['active'] = true;
                } else {
                    $menu[$key]['active'] = false;
                }
            }
        }

        return $menu;

    }

}