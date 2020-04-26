<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class IsAdmin
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
        if(Session::has('ROLE')){
            
            if(!session('ROLE')){
                return redirect('/');
            }
        
            return $next($request);
        }
        
        return redirect('/');
    }
}
