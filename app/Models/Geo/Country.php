<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'code',
        'slug',
    ];

    public function scopeSearch($query, $s)
    {
        if ($s != '') {
            $query->where('name', 'like', '%'.$s.'%')
                ->orWhere('code', 'like', '%'.$s.'%');
        }
        return $query;
    }
}
