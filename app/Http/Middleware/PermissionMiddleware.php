<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (! $request->user()->canDo($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
