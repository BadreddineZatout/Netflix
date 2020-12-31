<?php

namespace App\Http\Controllers\Core\Auth\User;

use App\Exceptions\GeneralException;
use App\Filters\Common\Auth\UserFilter as AppUserFilter;
use App\Filters\Core\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Auth\User\UserRequest;
use App\Jobs\User\UserDeleted;
use App\Models\Core\Auth\User;
use App\Notifications\Core\User\UserNotification;
use App\Services\Core\Auth\UserService;

/**
 * Class UserController.
 */
class UserController extends Controller
{

    /**
     * UserController constructor.
     *
     * @param UserService $user
     * @param UserFilter $filter
     */
    public function __construct(UserService $user, UserFilter $filter)
    {
        $this->service = $user;
        $this->filter = $filter;
    }


    /**
     *
     * @return mixed
     */
    public function index()
    {
        return (new AppUserFilter(
            $this->service
                ->filters($this->filter)
                ->select(['id', 'first_name', 'last_name', 'email', 'created_by', 'status_id', 'created_at'])
                ->with('roles:id,name,is_admin,is_default,type_id', 'status', 'profilePicture')
                ->latest()
        ))->filter()
            ->paginate(request()->get('per_page', 10));
    }


    /**
     * @param UserRequest $request
     * @return array
     */
    public function store(UserRequest $request)
    {
        $user = $this->service->create();

        if ($roles = $request->get('roles', config('access.default_role')))
            $user->assignRole($roles);

        notify()
            ->on('user_created')
            ->with($user)
            ->send(UserNotification::class);

        return created_responses('user');
    }


    /**
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user->load('roles');
    }


    /**
     * @param UserRequest $request
     * @param User $user
     * @return array
     * @throws GeneralException
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->service->update($user);

        if ($roles = $request->get('roles'))
            $user->assignRole($roles);

        return updated_responses('user');
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return array
     * @throws GeneralException
     */
    public function destroy(UserRequest $request, User $user)
    {
        $this->service->delete($user);

        notify()
            ->on('user_deleted')
            ->with((object)$user->toArray())
            ->send(UserNotification::class);

        UserDeleted::dispatch((object) $user->toArray())
            ->onConnection('sync');

        return deleted_responses('user');
    }
}
