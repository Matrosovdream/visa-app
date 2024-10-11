<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'price',
        'published',
        'published_at',
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries', 'product_id', 'country_id');
    }
    

}
