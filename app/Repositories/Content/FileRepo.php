<?php

namespace App\Repositories\Content;

use App\Repositories\AbstractRepo;
use App\Models\Content\File;

class FileRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new File();
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return [
            'id' => $item->id,
            'filename' => $item->filename,
            'path' => $item->path,
            'type' => $item->type,
            'size' => $item->size,
            'extension' => $item->extension,
            'description' => $item->description,
            'disk' => $item->disk,
            'visibility' => $item->visibility,
            'Model' => $item,
        ];
    }
}
