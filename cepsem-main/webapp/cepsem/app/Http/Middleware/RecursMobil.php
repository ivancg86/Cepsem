<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecursMobil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if((Auth::user()->rols_id == 1) ||(Auth::user()->rols_id == 3) ){
            return $next($request);
        }
        return redirect('login');

    }
}
