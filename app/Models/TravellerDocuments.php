<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravellerDocuments extends Model
{
    protected $fillable = [
        'traveller_id',
        'type',
        'filename',
        'path',
        'description',
    ];

    public function traveller()
    {
        return $this->belongsTo(Traveller::class);
    }

    public function getDocumentPathAttribute()
    {
        return asset('storage/' . $this->path);
    }

}
