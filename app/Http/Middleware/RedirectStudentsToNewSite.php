<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectStudentsToNewSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('local') && $request->user() && $request->user()->isStudent()) {
            $url = config('app.student_app_url');

            if ($url !== null) {
                auth()->logout();
                session()->regenerate(true);

                return redirect()->away($url);
            }
        }

        return $next($request);
    }
}
