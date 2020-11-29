<?php


namespace App\Services\Core;


use Illuminate\Database\Eloquent\Model;

class BaseService
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    public function save($options = [])
    {
        $this->model
            ->fill(count($options) ? $options : request()->all())
            ->save();
        return $this->model;
    }

    public function find($id)
    {
        return $this->model =  $this->model::query()->find($id);
    }

    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

}
