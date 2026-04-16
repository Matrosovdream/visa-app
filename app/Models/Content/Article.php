<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\User\User;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
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
        if ($s != '') {
            $query->where('title', 'like', '%'.$s.'%')
                ->orWhere('short_description', 'like', '%'.$s.'%')
                ->orWhere('content', 'like', '%'.$s.'%');
        }
        return $query;
    }
}
