<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;

class BlockDeactivatedUsers
{
    public function __invoke(Request $request, callable $next)
    {
        if(is_null(auth()->user()->deactivated_at))
        {
            return $next($request);
        }

        auth()->logout();
        return redirect('/login');
    }
}
