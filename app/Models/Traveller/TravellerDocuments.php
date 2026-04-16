<?php

namespace App\Models\Traveller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content\File;

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

    public function document()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
