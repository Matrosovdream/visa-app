<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Metaable;


class ProductExtras extends Model
{

    use Metaable;

    protected $fillable = [
        'product_id',
        'name',
        'price',
    ];

    public function meta()
    {
        return $this->hasMany(ProductExtrasMeta::class);
    }

    public function getPriceAttribute($value) {
        return number_format($value, 0);
    }

}
