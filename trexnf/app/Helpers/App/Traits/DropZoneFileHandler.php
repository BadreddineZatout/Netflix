<?php

namespace App\Helpers\App\Traits;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait DropZoneFileHandler
{
    protected $storage_prefix = 'public';

    public function storeDropZoneFiles($image,$namePrefix,$destination )
    {
        list($type, $file) = explode(';',$image);
        list(, $extension) = explode('/', $type);
        list(, $file) = explode(',', $file);
        $fileNameToStore = $namePrefix.rand(1, 100000000).'.'.$extension;


        $source = fopen($image, 'r');

        //create directory if not created
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }
        $destination = fopen($destination . $fileNameToStore, 'w');

        stream_copy_to_stream($source, $destination);
        fclose($source);
        fclose($destination);

        return $fileNameToStore;
    }

}