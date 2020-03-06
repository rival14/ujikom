<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Masyarakat
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
        if (Session::has('nik')) {
            return $next($request);
        }
        
        return redirect('/')->withErrors('Anda harus login terlebih dahulu');
        
    }
}
