<?php

namespace App\Services\App\UserServices;


use App\Models\Core\Auth\User;
use App\Services\App\AppService;

class UserService extends AppService
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}