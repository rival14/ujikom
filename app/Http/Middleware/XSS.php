<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $Request, Closure $next)
    {
        $input = $Request->all();
        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
        });
        $Request->merge($input);

        return $next($Request);
    }
}
