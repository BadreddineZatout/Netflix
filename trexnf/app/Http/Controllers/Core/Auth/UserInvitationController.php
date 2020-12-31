<?php

namespace App\Http\Controllers\Core\Auth;

use App\Hooks\User\AfterUserInvited;
use App\Hooks\User\BeforeUserInvited;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Auth\User\UserInvitationRequest as Request;
use App\Models\App\User\SocialLink;
use App\Models\Core\Status;
use App\Notifications\Core\User\UserInvitationNotification;
use App\Services\Core\Auth\UserInvitationService;

class UserInvitationController extends Controller
{

    /**
     * @var BeforeUserInvited
     */
    private $beforeInvited;

    /**
     * @var AfterUserInvited
     */
    private $afterInvited;

    public function __construct(UserInvitationService $service, BeforeUserInvited $beforeInvited, AfterUserInvited $afterInvited)
    {
        $this->service = $service;
        $this->beforeInvited = $beforeInvited;
        $this->afterInvited = $afterInvited;
    }

    public function invite(Request $request)
    {
        $this->beforeInvited
            ->handle();

        $user = $this->service->invite(
            $request->get('email'),
            $request->get('roles', [])
        );

        //GUD app level code start
        $socialLinks = SocialLink::pluck('id')->toArray();
        $user->assignSocialLinks($socialLinks);
        //End

        notify()
            ->on('user_invited')
            ->with($user)
            ->send(UserInvitationNotification::class);

        log_to_database(trans('default.user_invited_to_join'), [
            'old' => [],
            'attributes' => $user
        ]);

        $user->load('roles');

        $this->afterInvited
            ->setModel($user)
            ->handle();

        return response()->json([
            'status' => true,
            'message' => trans('default.invite_user_response')
        ]);

    }
}
