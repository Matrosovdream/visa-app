<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\PaymentGateway;

class OrderPayment extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

}
