<?php

namespace App\Http\Middleware;

use Auth;
use App;

class UserDefaults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next)
    {
        if(env('DB_DATABASE') == '' || !\Schema::hasTable('global_settings')) {
            return $next($request);
        }

        if($request->bearerToken() != '' && Auth::guard('api')->check()) {
            session(['is_mobile' => true]);
        }

        $user_language = session('language');
        
        if($user_language == '' || !in_array($user_language,['en','ar'])) {
            $user_language = global_settings('default_language');
        }


        if(!defined('LOCALE')) {
            define('LOCALE',$user_language);
        }

        App::setLocale($user_language);

        session(['language' => $user_language]);

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        return $response;
    }
}