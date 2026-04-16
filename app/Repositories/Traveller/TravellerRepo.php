<?php

namespace App\Repositories\Traveller;

use App\Repositories\AbstractRepo;
use App\Models\Traveller\Traveller;

class TravellerRepo extends AbstractRepo
{
    protected $withRelations = ['meta', 'documents', 'orders'];

    public function __construct()
    {
        $this->model = new Traveller();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'full_name' => $item->full_name,
            'name' => $item->name,
            'lastname' => $item->lastname,
            'birthday' => $item->birthday,
            'passport' => $item->passport,
            'meta' => $item->meta,
            'documents' => $item->documents,
            'Model' => $item,
        ];
    }
}
