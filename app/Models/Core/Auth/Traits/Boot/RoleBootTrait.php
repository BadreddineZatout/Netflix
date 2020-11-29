<?php


namespace App\Models\Core\Auth\Traits\Boot;


use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;

trait RoleBootTrait
{
    public static function boot()
    {
        parent::boot();

        if (!app()->runningInConsole()) {
            static::creating(function($model){
                if (!$model->created_by) {
                    return $model->fill([
                        'created_by' => auth()->id()
                    ]);
                }
            });
        }

        static::updated(function (Role $role) {
            $role->users->map(function (User $user) {
                cache()->forget('user-'.$user->id);
                cache()->forget('user-roles-permissions-'.$user->id);
                cache()->forget('user-roles-'.$user->id);
                cache()->forget('auth-user-permissions-'.$user->id);
            });
        });

        static::synced(function ($role, $relation, $properties) {
            $role->users->map(function (User $user) {
                cache()->forget('user-'.$user->id);
                cache()->forget('user-roles-permissions-'.$user->id);
                cache()->forget('user-roles-'.$user->id);
                cache()->forget('auth-user-permissions-'.$user->id);
            });
        });

        static::attached(function ($role, $relation, $properties) {
            $role->users->map(function (User $user) {
                cache()->forget('user-'.$user->id);
                cache()->forget('user-roles-permissions-'.$user->id);
                cache()->forget('user-roles-'.$user->id);
                cache()->forget('auth-user-permissions-'.$user->id);
            });
        });

        static::updatingExistingPivot(function ($role, $relation, $properties) {
            $role->users->map(function (User $user) {
                cache()->forget('user-'.$user->id);
                cache()->forget('user-roles-permissions-'.$user->id);
                cache()->forget('user-roles-'.$user->id);
                cache()->forget('auth-user-permissions-'.$user->id);
            });
        });
    }
}
