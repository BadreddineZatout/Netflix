<?php

namespace App\Services\App\UserServices;

use App\Models\Core\Auth\Role;
use App\Services\App\AppService;

class RolesService extends AppService
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

}