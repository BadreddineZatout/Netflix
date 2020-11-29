<?php


namespace App\Filters\Core;


use App\Filters\Core\traits\NameFilter;
use App\Filters\Core\traits\SearchFilterTrait;
use App\Filters\Core\traits\TypeFilter;
use App\Filters\FilterBuilder;

class RoleFilter extends FilterBuilder
{
    use NameFilter, SearchFilterTrait, TypeFilter;
}
