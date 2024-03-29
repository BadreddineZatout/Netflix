<?php

namespace App\Http\Middleware;

use App\Exceptions\GeneralException;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws GeneralException
     * @throws AuthorizationException
     *
     */
    public function handle($request, Closure $next)
    {
        $route_name = preg_replace('/core.|app.|tenant./', '', $request->route()->getName(), 1);

        if (!$route_name) {
            throw new GeneralException('Route must have a name');
        }

        /**
         * Avoid if the user is appAdmin
         */
        if (auth()->user()->isAppAdmin()) {
            return $next($request);
        }

        $exploded_route_name = explode('.', $route_name);

        if (count($exploded_route_name) > 2) {
            throw new GeneralException('Route name can\'t be more than 2 index. Eg.brand.list.change not allowed');
        }

        if (count($exploded_route_name) == 2) {
            $replacer_array = ['store' => 'create', 'index' => 'view', 'destroy' => 'delete', 'show' => 'view', 'lists' => 'view', 'edit' => 'update'];

            /*
             * if the index is exist in replacer array the replace the value with replacer array value
             * otherwise take the default value
            */
            $action = !empty($replacer_array[$exploded_route_name[1]]) ?
                $replacer_array[$exploded_route_name[1]] :
                $exploded_route_name[1];

            $permission_string = str_replace('-', '_', $action.'_'.$exploded_route_name[0]);
        } else {
            $route_name = str_replace('-', '_', $route_name);
            $permission_string = "manage_{$route_name}";
        }

        /*
         * Authorizing user with permission and merge allowed resource into allowed_resource index
         * if the allowed_resource is empty array then all resource is allowed
         * otherwise only take what in that array
         * allowed resource will contain ID's of model which is permitted for currently logged in user
         */
        $meta = get_authorized($permission_string);

        $request->merge([
            'allowed_resource' => $meta
        ]);

        return $next($request);
    }

}
