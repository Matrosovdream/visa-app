<?php

namespace App\Repositories\Product;

use App\Repositories\AbstractRepo;
use App\Models\Product\Product;

class ProductRepo extends AbstractRepo
{
    protected $withRelations = ['countries', 'meta', 'offers', 'extras'];

    public function __construct()
    {
        $this->model = new Product();
    }

    public function search($s, $paginate = 10)
    {
        $items = $this->model->with($this->withRelations)->search($s)->paginate($paginate);
        return $this->mapItems($items);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'description' => $item->description,
            'content' => $item->content,
            'image' => $item->image,
            'price' => $item->price,
            'published' => $item->published,
            'countries' => $item->countries,
            'meta' => $item->meta,
            'offers' => $item->offers,
            'extras' => $item->extras,
            'created_at' => $item->created_at,
            'Model' => $item,
        ];
    }
}
