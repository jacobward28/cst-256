<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class LoggedIn
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
        if(!Session::has('ID')){
            return redirect('/');    
        }
        
        return $next($request);
    }
}
