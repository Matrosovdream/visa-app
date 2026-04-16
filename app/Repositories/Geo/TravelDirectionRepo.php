<?php

namespace App\Repositories\Geo;

use App\Repositories\AbstractRepo;
use App\Models\Geo\TravelDirection;

class TravelDirectionRepo extends AbstractRepo
{
    protected $withRelations = ['countryFrom', 'countryTo', 'products'];

    public function __construct()
    {
        $this->model = new TravelDirection();
    }

    public function findPair($countryFromId, $countryToId)
    {
        $item = $this->model->where('country_from_id', $countryFromId)
            ->where('country_to_id', $countryToId)
            ->first();
        return $this->mapItem($item);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'country_from_id' => $item->country_from_id,
            'country_to_id' => $item->country_to_id,
            'countryFrom' => $item->countryFrom,
            'countryTo' => $item->countryTo,
            'products' => $item->products,
            'Model' => $item,
        ];
    }
}
