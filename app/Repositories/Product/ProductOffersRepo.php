<?php

namespace App\Repositories\Product;

use App\Repositories\AbstractRepo;
use App\Models\Product\ProductOffers;

class ProductOffersRepo extends AbstractRepo
{
    protected $withRelations = ['meta', 'product'];

    public function __construct()
    {
        $this->model = new ProductOffers();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $item->name,
            'price' => $item->price,
            'meta' => $item->meta,
            'Model' => $item,
        ];
    }
}
