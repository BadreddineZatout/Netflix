<?php


namespace App\Filters\Common;


use Illuminate\Database\Eloquent\Builder;

abstract class FilterContact
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * @return Builder
     */
    abstract function filter() : Builder;
}
