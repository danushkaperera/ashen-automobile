<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            auth()->logout();

            return redirect()->route('admin.login');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if ($user->isStaffMember() && $user->canAccessRoute($routeName)) {
            return $next($request);
        }

        return redirect($user->isStaffMember() ? $user->homePath() : route('staff.login'))
            ->with('error', 'You do not have access to the admin dashboard or that page.');
    }
}
