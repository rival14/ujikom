<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class adminLogin
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
        if (Session::get('status') == 'admin' OR Session::get('status') == 'petugas') {
            return $next($request);
        }else{
            return redirect('/')->withErrors('Anda harus login terlebih dahulu');
        }

    }
}
