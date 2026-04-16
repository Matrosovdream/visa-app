<?php

namespace App\Repositories\Product;

use App\Repositories\AbstractRepo;
use App\Models\Product\ProductExtras;

class ProductExtrasRepo extends AbstractRepo
{
    protected $withRelations = ['meta'];

    public function __construct()
    {
        $this->model = new ProductExtras();
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
