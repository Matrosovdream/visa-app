<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Metaable;

class ProductExtras extends Model
{
    use Metaable;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
    ];

    public function meta()
    {
        return $this->hasMany(ProductExtrasMeta::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 0);
    }
}
