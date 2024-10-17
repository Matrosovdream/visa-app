<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExtras extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
    ];

    public function meta()
    {
        return $this->hasMany(ProductExtrasMeta::class);
    }

}
