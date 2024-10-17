<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExtrasMeta extends Model
{

    protected $table = 'product_extras_meta';
    protected $fillable = [
        'extra_id',
        'key',
        'value',
    ];

    public function extra()
    {
        return $this->belongsTo(ProductExtras::class);
    }
    
}
