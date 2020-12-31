<?php

namespace App\Http\Controllers\App\InputFields;

use App\Http\Controllers\Controller;
use App\Services\App\Fields\FileService;
use Illuminate\Http\Request;

class FilesFieldController extends Controller
{
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        if (empty($request->all())) return nothing_store();

        $input = $this->service->inputDataProcessing($request);

        return file_upload_responses('file', compact('input'));
    }

    public function multiFileStore(Request $request)
    {
        if (empty($request->all())) return nothing_store();
        $input = $this->service->multiFileUpload($request);

        return file_upload_responses('file', compact('input'));
    }
}
