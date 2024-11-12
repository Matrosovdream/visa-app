<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOffers extends Model
{

    protected $fillable = [
        'product_id',
        'name',
        'price',
    ];

    public function meta()
    {
        return $this->hasMany(ProductOffersMeta::class, 'offer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getMeta($key)
    {
        return $this->meta->where('key', $key)->first()->value;
    }

    public function getPriceAttribute($value) {
        return number_format($value, 0);
    }

}
