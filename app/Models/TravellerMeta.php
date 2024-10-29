<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravellerMeta extends Model
{

    protected $table = 'traveller_meta';
    protected $fillable = [
        'traveller_id',
        'key',
        'value',
    ];

    public function traveller()
    {
        return $this->belongsTo(Traveller::class);
    }

}
