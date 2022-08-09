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

        \View::share('site_name', global_settings('site_name'));

        $site_logo = $this->getImageUrl('logo');

        \View::share('site_logo', $site_logo);

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        return $response;
    }

    /**
     * Get Image Url
     *
     * @return String Image Url
     */
    protected function getImageUrl($type)
    {
        $global_settings = resolve("GlobalSetting");
        $upload_drivers = view()->shared('upload_drivers');

        $global_setting = $global_settings->where('name',$type)->first();
        $upload_driver = $global_settings->where('name',$type.'_driver')->first();
        $handler = resolve('App\Services\ImageHandlers\\'.$upload_drivers[$upload_driver->value].'ImageHandler');
        $logo = explode('.',$global_setting->value);
        $locale = session('language');
        $image_data['name'] = $logo[0].'_'.$locale.'.'.$logo[1];
        $image_data['version_based'] = true;
        $image_data['path'] = $global_setting->filePath;

        return $handler->fetch($image_data);
    }
}