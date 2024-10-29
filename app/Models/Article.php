<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Article extends Model
{

    use HasFactory;
    use softDeletes;
    use Translatable;

    public $translatedAttributes = ['title', 'short_description', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function scopeSearch($query, $s)
    {
        // Search in name and description, content
        if ( $s != '' ) {
            $query->where('title', 'like', '%'.$s.'%')
                ->orWhere('short_description', 'like', '%'.$s.'%')
                ->orWhere('content', 'like', '%'.$s.'%');
        }

        return $query;
    }

}
