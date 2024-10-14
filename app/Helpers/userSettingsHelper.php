<?php
namespace App\Helpers;

class userSettingsHelper {

    public static function getTopMenu() {

        $menu = array(
            array(
                'title' => 'Main',
                'url' => route('user.index'),
            ),
            array(
                'title' => 'Articles',
                'url' => route('user.articles.index'),
            )
            
            /*
            array(
                'title' => 'Content',
                'url' => '',
                'icon' => 'ki-file',
                'childs' => array(
                    array(
                        'title' => 'Articles',
                        'url' => route('admin.articles.index'),
                    ),
                    array(
                        'title' => 'Countries',
                        'url' => route('admin.countries.index'),
                    ),
                    array(
                        'title' => 'Travel Directions',
                        'url' => route('admin.directions.index'),
                    ),
                ),
            ),
            */
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