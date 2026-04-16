<?php

namespace App\Repositories\Content;

use App\Repositories\AbstractRepo;
use App\Models\Content\Article;

class ArticleRepo extends AbstractRepo
{
    protected $withRelations = ['author'];

    public function __construct()
    {
        $this->model = new Article();
    }

    public function search($s, $paginate = 10)
    {
        $items = $this->model->with($this->withRelations)->search($s)->paginate($paginate);
        return $this->mapItems($items);
    }

    public function getBySlug($slug)
    {
        $item = $this->model->with($this->withRelations)->where('slug', $slug)->first();
        return $this->mapItem($item);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'title' => $item->title,
            'slug' => $item->slug,
            'short_description' => $item->short_description,
            'content' => $item->content,
            'author_id' => $item->author_id,
            'author' => $item->author,
            'created_at' => $item->created_at,
            'Model' => $item,
        ];
    }
}
