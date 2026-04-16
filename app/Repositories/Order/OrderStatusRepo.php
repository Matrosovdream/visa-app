<?php

namespace App\Repositories\Order;

use App\Repositories\AbstractRepo;
use App\Models\Order\OrderStatus;

class OrderStatusRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new OrderStatus();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'color' => $item->color,
            'is_default' => $item->is_default,
            'Model' => $item,
        ];
    }
}
