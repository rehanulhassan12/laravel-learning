<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckScreenAccess
{
   
    public function handle(Request $request, Closure $next,$screenName)
    {
          $user = $request->user();
          if (!$user) {
            abort(403, 'Unauthorized');
        }
         // Check if user has a role that has access to the screen
        $hasAccess = $user->roles()
                          ->whereHas('screens', fn($q) => $q->where('name', $screenName))
                          ->exists();
                           if (!$hasAccess) {
            abort(403, 'Access denied');

              return $next($request);
        }

         return $next($request);

    }
}
