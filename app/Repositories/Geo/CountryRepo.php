<?php

namespace App\Repositories\Geo;

use App\Repositories\AbstractRepo;
use App\Models\Geo\Country;

class CountryRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Country();
    }

    public function search($s, $paginate = 30)
    {
        $items = $this->model->search($s)->paginate($paginate);
        return $this->mapItems($items);
    }

    public function findBySlug($slug)
    {
        $item = $this->model->where('slug', $slug)->first();
        return $this->mapItem($item);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'code' => $item->code,
            'slug' => $item->slug,
            'Model' => $item,
        ];
    }
}
