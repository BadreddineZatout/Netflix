<?php

namespace App\Http\Controllers\Core\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Auth\User\UserThumbnailRequest;
use App\Services\Core\Auth\UserService;

/**
 * Class UserController.
 */
class UserThumbnailController extends Controller
{

    /**
     * UserController constructor.
     *
     * @param UserService $user
     */
    public function __construct(UserService $user)
    {
        $this->service = $user;
    }


    /**
     * @param UserThumbnailRequest $request
     * @return mixed
     */
    public function index(UserThumbnailRequest $request)
    {
        return $this->service->getProfilePicture();
    }


    /**
     * @param UserThumbnailRequest $request
     * @return array
     */
    public function store(UserThumbnailRequest $request)
    {

        activity()->withoutLogs(function(){
            $this->service->storeThumbnail();
        });

        return updated_responses('profile_picture');
    }

    public function update()
    {

    }
}
