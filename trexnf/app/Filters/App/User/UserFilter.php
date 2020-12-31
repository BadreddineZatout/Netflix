<?php

namespace App\Filters\App\User;


use App\Filters\App\Traits\DateRangeFilter;
use App\Filters\App\Traits\TabFilter;
use App\Filters\FilterBuilder;

class UserFilter extends FilterBuilder
{
    use DateRangeFilter, TabFilter;

    public function search($search = null)
    {
        $this->groupSearch($search, ['name', 'email', 'phone']);
    }
}