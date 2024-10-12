<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{

    use softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'price'
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'product_countries', 'product_id', 'country_id');
    }

    // Cast a slug from name using Str::slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

}
