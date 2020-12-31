<?php


namespace App\Helpers\Core\Traits;

trait Helpers
{
    /**
     * @param array $data
     * @return array
     */
    public function checkMakeArray($data = [])
    {
        return is_array($data)
            ? $data
            : [ $data ];
    }
}
