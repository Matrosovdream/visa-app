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
        'user_id',
        'order_id',
        'payment_gateway_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'payment_response'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    public function setPaymentResponseAttribute($value)
    {
        $this->attributes['payment_response'] = json_encode($value);
    }

    public function getPaymentResponseAttribute($value)
    {
        return json_decode($value, true);
    }

}
