<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckViewOnlyRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        $method = $request->method();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Jika superadmin, hanya izinkan GET
        if ($user->hasRole('superadmin') && $method === 'GET') {
            return $next($request);
        }

        // Jika bukan superadmin, cek role seperti biasa
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
