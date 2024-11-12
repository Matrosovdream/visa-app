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

    public function meta()
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function extras()
    {
        return $this->hasMany(ProductExtras::class);
    }

    public function offers()
    {
        return $this->hasMany(ProductOffers::class);
    }

    public function getMeta( $slug )
    {
        return $this->meta->where('key', $slug)->first()->value;
    }

    // Search by fields
    public function scopeSearch($query, $s)
    {
        // Search in name and description, content
        if ( $s != '' ) {
            $query->where('name', 'like', '%'.$s.'%')
                ->orWhere('description', 'like', '%'.$s.'%')
                ->orWhere('content', 'like', '%'.$s.'%');
        }

        return $query;
    }

    public function updateMeta( $slug, $value )
    {
        $meta = $this->meta->where('key', $slug)->first();

        if ($meta) {
            $meta->value = $value;
            $meta->save();
        } else {
            $this->meta()->create([
                'key' => $slug,
                'value' => $value
            ]);
        }
    }

    // Cast a slug from name using Str::slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Format price field to 2 decimal places
    public function getPriceAttribute($value) {
        return number_format($value, 0);
    }

}
