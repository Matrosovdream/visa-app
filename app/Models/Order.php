<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meta()
    {
        return $this->hasMany(OrderMeta::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price', 'total');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
        });
    }

    public function getTotal()
    {
        return $this->products->sum(function ($product) {
            return $product->price;
        });
    }

}
