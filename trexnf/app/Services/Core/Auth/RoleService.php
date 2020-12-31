<?php


namespace App\Services\Core\Auth;

use App\Exceptions\GeneralException;
use App\Models\Core\Auth\Role;
use App\Notifications\Core\Role\RoleNotification;
use App\Services\Core\BaseService;

class RoleService extends BaseService
{
    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }


    public function update(Role $role)
    {
        if ($role->isDefault())
            throw new GeneralException(trans('default.default_delete', ['name' => 'role']));

        $this->model = $role;

        $role->fill(request()->except('is_default', 'is_admin'));

        if ($role->isDirty() || ($role->permissions()->count() !== count(request()->get('permissions', [])))) {
            notify()
                ->on('roles_updated')
                ->with($role)
                ->send(RoleNotification::class);
        }
        $role->save();
        return $role;
    }

    public function delete(Role $role)
    {
        if ($role->isDefault())
            throw new GeneralException(trans('default.default_delete', ['name' => 'role']));

        return $role->delete();
    }


    public function assignPermissions(array $permissions, $attach = false)
    {
        if (!$attach)
            return $this->model->permissions()->sync($permissions);

        foreach ($permissions as $permission) {
            $this->model->permissions()->attach($permission['permission_id'], [
                'meta' => json_encode(isset($permission['meta']) ? $permission['meta'] : [])
            ]);
        }
        return true;
    }


    public function syncPermissions(array $permissions)
    {
        $this->model->permissions()->sync([]);
        return $this->assignPermissions($permissions);
    }


    public function attachPermissions(Role $role)
    {
        if ($role->isDefault())
            throw new GeneralException(trans('default.default_update', ['name' => 'role']));

        $permissions = is_array(request('permissions')) ? request('permissions') : [request('permissions')];
        foreach ($permissions as $key => $permission) {
            if (!$role->permissions->contains($permission)) {
                $role
                    ->permissions()
                    ->attach($permission);
            }
        }

        return $role->load('permissions');
    }

    public function detachPermissions(Role $role)
    {
        $permissions = is_array(request('permissions')) ? request('permissions') : [request('permissions')];

        $role
            ->permissions()
            ->detach($permissions);

        return $role->load("permissions");
    }



}
