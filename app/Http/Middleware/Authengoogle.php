<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Mylib\Users;

class Authengoogle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $redirectTo = 'login')
    {
        $User = new Users();

        app()->singleton('MyUser', function () use ($User) {
            return $User;
        });
        if(!$User->checklogin()){
            return redirect($redirectTo);
        }

        return $next($request);
    }
}
