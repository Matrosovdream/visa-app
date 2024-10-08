<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'status',
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

    public function addProduct($product, $quantity = 1)
    {
        $cartProduct = $this->products()->where('product_id', $product->id)->first();
        if ($cartProduct) {
            $cartProduct->quantity += $quantity;
            $cartProduct->total = $cartProduct->quantity * $cartProduct->price;
            $cartProduct->save();
        } else {
            $this->products()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'total' => $product->price * $quantity,
            ]);
        }
    }

}
