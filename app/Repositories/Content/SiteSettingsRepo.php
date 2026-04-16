<?php

namespace App\Repositories\Content;

use App\Repositories\AbstractRepo;
use App\Models\Content\SiteSettings;

class SiteSettingsRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new SiteSettings();
    }

    public function get($key)
    {
        return SiteSettings::get($key);
    }

    public function set($key, $value)
    {
        SiteSettings::set($key, $value);
    }

    public function remove($key)
    {
        SiteSettings::remove($key);
    }

    public function getSettings()
    {
        return SiteSettings::getSettings();
    }

    public function getSettingsList()
    {
        return SiteSettings::getSettingsList();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'key' => $item->key,
            'value' => $item->value,
            'Model' => $item,
        ];
    }
}
