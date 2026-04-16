<?php
namespace App\Services;

use App\Models\Content\SiteSettings;

class SiteSettingsService
{
    public static function getAllSettings()
    {
        $settings = SiteSettings::getSettings();

        $list = [];
        foreach ($settings as $setting) {
            $list[$setting['key']] = $setting['value'];
        }

        return $list;
    }
}
