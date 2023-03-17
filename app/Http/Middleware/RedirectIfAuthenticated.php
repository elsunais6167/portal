<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() ) {
            $user = auth()->user();
            if( request()->has('uid')):
                $url = route('login', ['pid' => uniqid(), 'uid' => request()->uid , 'sid' => $user->school_id]);
                if( request()->uid != $user->id ){
                    auth()->logout();
                    return redirect($url);
                } 
            endif;
            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
    }
}
