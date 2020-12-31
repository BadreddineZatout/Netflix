<?php


namespace App\Models\Core\Auth\Traits\Boot;


trait UserBootTrait
{
    public static function boot() : void
    {
        parent::boot();
        if (!app()->runningInConsole()){
            static::creating(function($model){
                return $model->fill([
                    'created_by' => auth()->id()
                ]);
            });
        }

        static::saved(function ($user) {
            cache()->forget('user-'.$user->id);
            cache()->forget('user-roles-permissions-'.$user->id);
            cache()->forget('user-roles-'.$user->id);
            cache()->forget('auth-user-permissions-'.$user->id);
        });

        static::synced(function ($user, $relation, $properties) {
            cache()->forget('user-'.$user->id);
            cache()->forget('user-roles-permissions-'.$user->id);
            cache()->forget('user-roles-'.$user->id);
            cache()->forget('auth-user-permissions-'.$user->id);
        });

        static::attached(function ($user, $relation, $properties) {
            cache()->forget('user-'.$user->id);
            cache()->forget('user-roles-permissions-'.$user->id);
            cache()->forget('user-roles-'.$user->id);
            cache()->forget('auth-user-permissions-'.$user->id);
        });

        static::updatingExistingPivot(function ($user, $relation, $properties) {
            cache()->forget('user-'.$user->id);
            cache()->forget('user-roles-permissions-'.$user->id);
            cache()->forget('user-roles-'.$user->id);
            cache()->forget('auth-user-permissions-'.$user->id);
        });

    }
}
