<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'session_id',
        'currency',
    ];

    public function products()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function total()
    {
        return $this->products->sum('total');
    }

    public function totalQuantity()
    {
        return $this->products->sum('quantity');
    }

    public function totalItems()
    {
        return $this->products->count();
    }

}
