<?php

namespace App\Repositories\Geo;

use App\Repositories\AbstractRepo;
use App\Models\Geo\Language;

class LanguageRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Language();
    }

    public function getActive()
    {
        $items = $this->model->active()->get();
        return $this->mapItems($items);
    }

    public function getDefault()
    {
        $item = $this->model->default()->first();
        return $this->mapItem($item);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'code' => $item->code,
            'symbol' => $item->symbol,
            'is_default' => $item->is_default,
            'is_active' => $item->is_active,
            'Model' => $item,
        ];
    }
}
