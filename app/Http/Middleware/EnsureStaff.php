<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            auth()->logout();

            return redirect()->route('staff.login');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (! $user->isStaffMember()) {
            abort(403);
        }

        $routeName = $request->route()?->getName();

        if ($user->canAccessRoute($routeName)) {
            return $next($request);
        }

        return redirect($user->homePath())
            ->with('error', 'You do not have access to that page.');
    }
}
