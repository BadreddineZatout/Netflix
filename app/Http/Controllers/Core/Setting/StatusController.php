<?php

namespace App\Http\Controllers\Core\Setting;

use App\Filters\Core\StatusFilter;
use App\Http\Controllers\Controller;
use App\Models\Core\Status;

class StatusController extends Controller
{
    public function __construct(StatusFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $key = request()->get('type') ? 'statuses-'.request()->get('type') : 'statuses';

        return cache()->rememberForever($key, function () {
            return Status::query()
                ->filters($this->filter)
                ->get();
        });
    }
}
