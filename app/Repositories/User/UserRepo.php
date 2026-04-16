<?php

namespace App\Repositories\User;

use App\Repositories\AbstractRepo;
use App\Models\User\User;

class UserRepo extends AbstractRepo
{
    protected $withRelations = ['roles'];

    public function __construct()
    {
        $this->model = new User();
    }

    public function getByEmail($email)
    {
        $item = $this->model->with($this->withRelations)->where('email', $email)->first();
        return $this->mapItem($item);
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'is_active' => $item->is_active,
            'roles' => $item->roles,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
            'Model' => $item,
        ];
    }
}
