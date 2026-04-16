<?php

namespace App\Repositories\Order;

use App\Repositories\AbstractRepo;
use App\Models\Order\Order;

class OrderRepo extends AbstractRepo
{
    protected $withRelations = ['user', 'meta', 'status', 'travellers', 'cartProducts'];

    public function __construct()
    {
        $this->model = new Order();
    }

    public function getByHash($hash)
    {
        $item = $this->model->with($this->withRelations)->where('hash', $hash)->first();
        return $this->mapItem($item);
    }

    public function getByUser($user_id, $paginate = 10)
    {
        $items = $this->model->with($this->withRelations)->where('user_id', $user_id)->paginate($paginate);
        return $this->mapItems($items);
    }

    public function checkUserAccess($user_id, $order_id)
    {
        return $this->model->where('user_id', $user_id)->where('id', $order_id)->exists();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'hash' => $item->hash,
            'user_id' => $item->user_id,
            'total_price' => $item->total_price,
            'status_id' => $item->status_id,
            'is_paid' => $item->is_paid,
            'user' => $item->user,
            'status' => $item->status,
            'meta' => $item->meta,
            'travellers' => $item->travellers,
            'created_at' => $item->created_at,
            'Model' => $item,
        ];
    }
}
