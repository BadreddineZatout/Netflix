<?php


namespace App\Services\Core\Auth;

use App\Exceptions\GeneralException;
use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\Helpers;
use App\Hooks\User\AfterLogin;
use App\Hooks\User\BeforeLogin;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use App\Notifications\Core\User\UserNotification;
use App\Repositories\Core\Setting\SettingRepository;
use App\Services\Core\BaseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    use FileHandler, Helpers;

    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->model = $user;
        $this->role = $role;
    }

    public function create()
    {
        $status = Status::findByNameAndType('status_active', 'user')->id;

        parent::save(array_merge(request()->only(
            'first_name',
            'last_name',
            'email',
            'password'
        ), ['status_id' => $status]));

        return $this->model;
    }


    public function update(User $user)
    {
        $attributes = request()->only('first_name', 'last_name', 'status_id');

        $user->fill($attributes);

        if ($user->isDirty('status_id') && ($user->isAppAdmin() || $user->id == auth()->id()))
            throw new GeneralException(trans('default.action_not_allowed'));

        if ($user->isDirty()) {
            notify()
                ->on('user_updated')
                ->with($user)
                ->send(UserNotification::class);
        }

        $this->model = $user;

        $user->save();

        return $user;
    }

    public function delete(User $user)
    {
        if ($user->isAppAdmin() && !$user->isInvited())
            throw new GeneralException(trans('default.action_not_allowed'));

        if ($user->id == auth()->id())
            throw new GeneralException(trans('default.cant_delete_own_account'));

        return $user->delete();
    }


    public function attachRole(User $user)
    {
        if (($user->isAppAdmin() || $user->id == auth()->id()) && !$user->isInvited())
            throw new GeneralException(trans('default.action_not_allowed'));

        $roles = $this->checkMakeArray(request('roles'));
        $user->roles()->sync(array_unique($roles));
        return $user;
    }

    public function detachRole(User $user)
    {
        if ($user->isAppAdmin() || $user->id == auth()->id())
            throw new GeneralException(trans('default.action_not_allowed'));

        $roles = $this->checkMakeArray(request('roles'));
        $user->roles()->detach($roles);
        $user->load('roles');
        return $user;
    }

    public function changeSetting($user = null)
    {
        $this->setModel($user ?? auth()->user());

        $this->attachSettings(
            request()->only('gender', 'date_of_birth', 'address', 'contact')
        );

        return true;
    }

    public function attachSettings($settings)
    {
        $settings_models = [];
        foreach ($settings as $key => $setting) {
            $setting_model = $this->model
                ->settings()
                ->firstOrNew([
                    'name' => $key,
                    'context' => 'user'
                ]);

            $setting_model->fill([
                'value' => $key == 'date_of_birth' ? Carbon::parse($setting)->format('Y-m-d') : $setting,
                'public' => 1
            ]);

            array_push($settings_models, $setting_model);
        }

        return $this->model
            ->settings()
            ->saveMany($settings_models);
    }

    public function storeThumbnail($user = null)
    {
        $user = $user ?? auth()->user();

        $this->deleteImage(optional($user->profilePicture)->path);

        $file_path = $this->uploadImage(
            request()->file('profile_picture'),
            config('file.profile_picture.folder'),
            config('file.profile_picture.height')
        );

        $user->profilePicture()->updateOrCreate([
            'type' => 'profile_picture'
        ], [
            'path' => $file_path
        ]);

        return $user->load('profilePicture');

    }


    public function login()
    {
        /**@var $user User*/
        $user = $this->model::findByEmail( request()->get('email') );

        BeforeLogin::new(true)
            ->setModel($user)
            ->handle();

        if (!$user->roles->count())
            throw new AuthenticationException(trans('default.no_roles_found'));

        if (Hash::check(request()->get('password'), optional($user)->password)) {
            auth()->login(
                $user,
                request()->get('remember_me',false)
            );

            AfterLogin::new(true)
                ->setModel($user)
                ->handle();

            return $user;
        }

        throw new AuthenticationException(
            trans('default.incorrect_user_password', [
                'password' => trans('default.password'),
                'email' => trans('default.email')
            ])
        );
    }


    public function getFormattedSettings()
    {
        return resolve(SettingRepository::class)
            ->getFormattedSettings('user', User::class, auth()->id());
    }

    public function findAndCacheUser($id)
    {
        return cache()->remember('user-'.$id, 86400, function () use ($id) {
            return $this->select('id', 'first_name', 'last_name')->with('profilePicture')
                ->find($id);
        });
    }

}
