<?php

namespace App\Http\Middleware;

use App\Helpers\Api;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role1, $role2)
    {
        $user = auth()->user();

        if (!$user->hasRole($role1) && !$user->hasRole($role2)) {
            return Api::response(
                null,
                'Role Tidak Sesuai, anda tidak dapat mengakses endpoint ini'
            );
        }
        return $next($request);
    }
}
