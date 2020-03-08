<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class login
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
        if (!Session::has('nik')) {
            return $next($request);
        }else{
            return redirect('/dashboard')->withErrors('Anda Telah Login!');
        }
    }
}
