<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Flash;

class CheckModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //Ensures only moderator and admins can access the users index page which shows all users
    public function handle($request, Closure $next)
    {
        $user = Auth::user()->id;
        if (Auth::user()->role_id > 2) {
            Flash::error('Sorry you do not have permission to access this information');
            return redirect('home');
        }
        return $next($request);
    }
}
