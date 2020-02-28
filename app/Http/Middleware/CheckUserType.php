<?php

namespace App\Http\Middleware;

use Closure;

use Auth;



class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->type_id == 1) {
            return redirect()->route('adminHome');
        }

        if (Auth::user()->type_id == 2) {
            return redirect()->route('taskmasterHome');
        }

        if (Auth::user()->type_id == 3) {
            return redirect()->route('userHome');
        }


        // return $next($request);
    }
}
