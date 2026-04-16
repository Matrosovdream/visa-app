<?php

namespace App\Repositories\Content;

use App\Repositories\AbstractRepo;
use App\Models\Content\Review;

class ReviewRepo extends AbstractRepo
{
    protected $withRelations = ['user'];

    public function __construct()
    {
        $this->model = new Review();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'content' => $item->content,
            'rating' => $item->rating,
            'is_approved' => $item->is_approved,
            'user' => $item->user,
            'created_at' => $item->created_at,
            'Model' => $item,
        ];
    }
}
