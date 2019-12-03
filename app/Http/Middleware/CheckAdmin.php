<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Flash;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     //Ensures only admins can access the roles page
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role_id !== 1) {
            Flash::error('Sorry you do not have permission to access this information');
            return redirect('/home');
        }
        return $next($request);
    }
}
