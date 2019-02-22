<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class login_check
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
        //$email = Auth::user()->email;
        //https://stackoverflow.com/questions/17835886/laravel-authuser-id-trying-to-get-a-property-of-a-non-object
        if (Auth::check())
        {
            // The user is logged in...
            return $next($request);
        }
        else{
            return redirect('/login');
        }

    }
}
