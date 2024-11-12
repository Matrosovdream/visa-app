<?php
namespace App\Helpers;

class fileHelper
{

   


    /*
    public static function prepareFile($request) {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->store('uploads');
        $type = self::getType($filename);
        $size = self::getSize($path);
        $extension = self::getExtension($filename);
        $description = $request->description;
        $disk = self::getDisk($path);
        $visibility = self::getVisibility($path);

        return [
            'filename' => $filename,
            'path' => $path,
            'type' => $type,
            'size' => $size,
            'extension' => $extension,
            'description' => $description,
            'disk' => $disk,
            'visibility' => $visibility
        ];
    }

    public static function getFilename($filename)
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    public static function getExtension($filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public static function getType($filename)
    {
        return mime_content_type($filename);
    }
    public static function getMimeType($filename)
    {
        return mime_content_type($filename);
    }

    public static function getSize($filename)
    {
        return filesize($filename);
    }

    public static function getDisk($filename)
    {
        return config('filesystems.default');
    }

    public static function getVisibility($filename)
    {
        return 'public';
    }
    */

}