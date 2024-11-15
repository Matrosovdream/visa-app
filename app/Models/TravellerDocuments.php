<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravellerDocuments extends Model
{
    protected $fillable = [
        'traveller_id',
        'file_id',
    ];

    public function traveller()
    {
        return $this->belongsTo(Traveller::class);
    }

    // Has one document
    public function document()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }


}
