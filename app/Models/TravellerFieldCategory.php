<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravellerFieldCategory extends Model
{

    protected $table = 'traveller_field_categories';

    protected $fillable = [
        'name',
        'is_active',
        'description',
    ];

    public function fields()
    {
        return $this->hasMany(ProductTravellerField::class, 'category_id');
    }

}
