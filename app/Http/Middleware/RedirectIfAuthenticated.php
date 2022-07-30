<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    protected $exceptRoutes = ['complete_social_signup'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            $redirectTo = $guard == 'admin' ? 'admin.dashboard' : 'dashboard';
            if (Auth::guard($guard)->check() && !in_array($request->route()->getName(), $this->exceptRoutes)) {
                return redirect()->route($redirectTo);
            }
        }

        return $next($request);
    }
}
