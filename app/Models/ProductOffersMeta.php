<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOffersMeta extends Model
{

    protected $table = 'product_offers_meta';

    protected $fillable = [
        'offer_id',
        'key',
        'value',
    ];

    public function offer()
    {
        return $this->belongsTo(ProductOffers::class, 'offer_id');
    }

}
