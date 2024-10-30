<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTravellerField extends Model
{

    protected $table = 'product_traveller_fields';

    protected $fillable = [
        'name',
        'type',
        'category_id',
        'is_required',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(TravellerFieldCategory::class, 'category_id');
    }

}
