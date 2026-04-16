<?php

namespace App\Repositories\User;

use App\Repositories\AbstractRepo;
use App\Models\User\Role;

class RoleRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Role();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'title' => $item->title,
            'slug' => $item->slug,
            'description' => $item->description,
            'is_default' => $item->is_default,
            'Model' => $item,
        ];
    }
}
