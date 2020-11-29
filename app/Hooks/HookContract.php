<?php


namespace App\Hooks;


abstract class HookContract
{
    public $model;

    abstract public function handle();

    /**
     * @param mixed $model
     * @return HookContract
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
