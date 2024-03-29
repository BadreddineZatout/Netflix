<?php

namespace App\Services\App\Fields;

use App\Helpers\App\Traits\DropZoneFileHandler;
use App\Helpers\Core\Traits\FileHandler;
use App\Models\App\Fields\FilesField;
use App\Services\App\AppService;

class FileService extends AppService
{
    use FileHandler;
    use DropZoneFileHandler;

    public function __construct(FilesField $input)
    {
        $this->model = $input;
    }

    public function inputDataProcessing($request)
    {
        $fileStoredUrl = '';

        /*
         * Default type file
         */
        $defaultFileStoredUrl = '';
        $defaultFile = $request->default_file;
        if ($defaultFile) {
            $defaultFileStoredUrl = $this->storeFile($defaultFile);
        }
        $attributes['default_file'] = $defaultFileStoredUrl;


        /*
         * custom files stored
         */
        $customFile = $request->custom_file;
        if ($customFile) {
            $fileStoredUrl = $this->storeFile($customFile);
        }
        $attributes['custom_file'] = $fileStoredUrl;

        return $this->model->create($attributes);
    }

    public function multiFileUpload($request)
    {
        $dropzoneFiles = $request->dropzone_file;

        if (is_array($dropzoneFiles)) {
            foreach ($dropzoneFiles as $dropzoneFile) {
                $dropzone_file['dropzone_file'] = $this->storeFile($dropzoneFile);
                $this->model->create($dropzone_file);
            }
        }
        return true;
    }
}
