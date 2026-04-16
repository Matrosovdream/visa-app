<?php

namespace App\Repositories\Cart;

use App\Repositories\AbstractRepo;
use App\Models\Cart\Cart;

class CartRepo extends AbstractRepo
{
    protected $withRelations = ['products'];

    public function __construct()
    {
        $this->model = new Cart();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'order_id' => $item->order_id,
            'session_id' => $item->session_id,
            'currency' => $item->currency,
            'total' => $item->total(),
            'total_quantity' => $item->totalQuantity(),
            'total_items' => $item->totalItems(),
            'Model' => $item,
        ];
    }
}
