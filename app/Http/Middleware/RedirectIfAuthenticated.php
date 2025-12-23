<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{

   public function handle($request, Closure $next, ...$guards)
{
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Redirect based on role instead of default /home
            $user = Auth::guard($guard)->user();

            if ($user->roles->contains('name', 'student')) {
                return redirect('/student/dashboard');
            }

            return redirect($user->firstAccessibleScreen() ?? '/student/dashboard');
        }
    }

    return $next($request);
}
}
