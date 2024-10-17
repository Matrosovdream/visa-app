<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Order extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->hash = Str::random(32);
        });
    }

    protected $fillable = [
        'hash',
        'user_id',
        'total_price',
        'payment_method_id',
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
        return $this->hasMany(CartProduct::class);
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

    public static function getByHash($hash)
    {
        return static::where('hash', $hash)->first();
    }

}
