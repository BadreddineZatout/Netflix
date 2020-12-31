<?php


namespace App\Services\Core\Auth;


use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use App\Services\Core\BaseService;

class UserInvitationService extends BaseService
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function invite($email, $roles = [])
    {
        $status = Status::findByNameAndType('status_invited')->id;

        $invitation_token = base64_encode($email.'-invitation-from-us');

        $this->model->fill([
            'email' => $email,
            'status_id' => $status,
            'invitation_token' => $invitation_token
        ])->save();


        $roles = count($roles) ? $roles : request()->get('roles');

        foreach ($roles as $key => $role) {
            $this->model->assignRole($role);
        }

        $this->model->invite();

        return $this->model;
    }
}
