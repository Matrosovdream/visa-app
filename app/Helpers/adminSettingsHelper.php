<?php
namespace App\Helpers;

class adminSettingsHelper {

    public static function getSidebarMenu() {

        $menu = array(
            array(
                'title' => 'Store',
                'url' => '',
                'icon' => 'ki-basket',
                'childs' => array(
                    array(
                        'title' => 'Products',
                        'url' => route('admin.products.index'),
                    ),
                    array(
                        'title' => 'Orders',
                        'url' => route('admin.orders.index'),
                    ),
                    array(
                        'title' => 'Payment gateways',
                        'url' => route('admin.settings.index'),
                    ),
                ),
            ),
            array(
                'title' => 'Settings',
                'url' => '',
                'icon' => 'ki-element-11',
                'childs' => array(
                    array(
                        'title' => 'Countries',
                        'url' => route('admin.countries.index'),
                    ),
                    array(
                        'title' => 'Users',
                        'url' => route('admin.users.index'),
                    ),
                    array(
                        'title' => 'Articles',
                        'url' => route('admin.articles.index'),
                    ),
                    array(
                        'title' => 'Directions',
                        'url' => route('admin.directions.index'),
                    ),
                ),
            ),
        );

        return self::setActiveMenus($menu);

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