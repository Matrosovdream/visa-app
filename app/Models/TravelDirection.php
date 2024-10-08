<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelDirection extends Model
{

    protected $fillable = ['name', 'slug', 'country_from_id', 'country_to_id'];

    public function countryFrom()
    {
        return $this->belongsTo(Country::class, 'country_from_id');
    }

    public function countryTo()
    {
        return $this->belongsTo(Country::class, 'country_to_id');
    }

    public function findPair($countryFromId, $countryToId)
    {
        return $this->where('country_from_id', $countryFromId)
            ->where('country_to_id', $countryToId)
            ->first();
    }


}
