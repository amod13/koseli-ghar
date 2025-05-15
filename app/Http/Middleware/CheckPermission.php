<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();


        // Get the full controller and action from the route, e.g., "App\Http\Controllers\JournalController@create"
        $action = Route::currentRouteAction();

        // Split the action into controller and method
        list($controller, $method) = explode('@', class_basename($action));

        // Fetch the permission ID for the given controller and method (action)
        $permission = DB::table('permissions')
            ->where('controller', $controller)
            ->where('action', $method)
            ->first();

        if (!$permission) {
            abort(403, 'Permission not defined for this action.');
        }

        // Check if the user's role has this permission
        $hasPermission = DB::table('role_has_permission')
            ->where('role_id', $user->role_id)
            ->where('permission_id', $permission->id)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
