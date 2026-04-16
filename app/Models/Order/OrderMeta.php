<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    protected $table = 'order_meta';

    protected $fillable = [
        'order_id',
        'key',
        'value',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
