<?php

namespace App\Repositories\Payment;

use App\Repositories\AbstractRepo;
use App\Models\Payment\PaymentGateway;

class PaymentGatewayRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new PaymentGateway();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'description' => $item->description,
            'image' => $item->image,
            'is_active' => $item->is_active,
            'Model' => $item,
        ];
    }
}
