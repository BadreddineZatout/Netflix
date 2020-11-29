<?php

namespace App\Models\Core\Auth\Traits\Scope;

use App\Filters\FilterBuilder;

/**
 * Class UserScope.
 */
trait UserScope
{
    public function scopeFilters($query, FilterBuilder $filter)
    {
        return $filter->apply($query);
    }
}
