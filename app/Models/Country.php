<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'code',
    ];

    // Search
    public function scopeSearch($query, $s)
    {
        // Search in name and description, content
        if ( $s != '' ) {
            $query->where('name', 'like', '%'.$s.'%')
                ->orWhere('code', 'like', '%'.$s.'%');
        }

        return $query;
    }

}
