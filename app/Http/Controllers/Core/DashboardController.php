<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Auth\Role;
use App\Models\User_Role;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = User_Role::where('user_id', Auth::user()->id)->first()->role_id;
        $is_admin = Role::findOrFail($role)->is_admin;
        return view('dashboard.default', [
            'is_admin' => $is_admin
        ]);
    }
}
