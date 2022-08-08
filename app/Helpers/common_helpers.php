<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

/**
 * Resolve Global Settings and get value of given string
 *
 * @param  string $key Name of the value to get
 * @return String
 */
if (!function_exists('global_settings')) {

    function global_settings($key,$original = false)
    {
        try {
            $global_settings = resolve('GlobalSetting');
            $global_setting = $global_settings->where('name',$key)->first();
            
            $value = optional($global_setting)->value;
            if($original) {
                return $value;
            }
            if(in_array($key,['site_name','about'])) {
                $value = json_decode($value,true);
                $locale = app()->getLocale();
                return $value[$locale] ?? '';
            }

            return $value;
        }
        catch (\Exception $e) {
            return '';
        }
    }
}

/**
 * Resolve Credentials and get value of given string
 *
 * @param  string $key Name of the value to get
 * @param  string $site Name of the site to get
 * @return String
 */
if (!function_exists('credentials')) {

    function credentials($key, $site)
    {
        $credentials = resolve('Credential');
        $credential = $credentials->where('name',$key)->where('site',$site)->first();
        
        return optional($credential)->value;
    }
}

/**
 * Resolve Meta and get value of current Route
 *
 * @param  string $field Name of the value to get
 * @return String
 */
if (!function_exists('getMetaData')) {

    function getMetaData($field,$default_value = '')
    {
        $meta_data = resolve('Meta');
        $page_data = $meta_data->where('route_name',Route::currentRouteName())->first();
        if($field == 'title') {
            $title = optional($page_data)->title;
            if($title == '') {
                return Lang::get('messages.errors.page_not_found');
            }
            $replace_keys = ['{SITE_NAME}','{SLUG}','{LIST_NAME}','{PAGE}'];
            if(request()->page != '') {
                $page = Str::of(request()->page)->replace('-',' ')->title();
            }
            $replace_values = [SITE_NAME,request()->slug ?? '',view()->shared('wishlist_name') ?? '',$page ?? ''];
            return Str::of($title)->replace($replace_keys,$replace_values);
        }
        return optional($page_data)->$field ?? $default_value;
    }
}

/**
 * Check Can display default Credentials
 *
 * @return Boolean
 */
if (!function_exists('isSecure')) {
    function isSecure()
    {
        return request()->isSecure();
    }
}


/**
 * Get Status Text of give code
 *
 * @param  Int $status
 * @param  string $status_text text related to given status code
 */
if(!function_exists('getStatusText')) {
    function getStatusText($status)
    {
         $array = [
            '1' => Lang::get('messages.common.active'),
            '0' => Lang::get('messages.common.inactive'),
        ];
        return $array[$status] ?? '';
    }
}

/**
 * Get Yes Or No Text of give code
 *
 * @param  Int $value
 * @param  string $yes_no_text related to given value
 */
if(!function_exists('getYesNoText')) {
    function getYesNoText($value)
    {
        $array = [
            '1' => Lang::get('messages.common.yes'),
            '0' => Lang::get('messages.common.no'),
        ];
        return $array[$value] ?? '';
    }
}

/**
 * Set Flash Message function
 *
 * @param  string $state     Type of the state ['danger','success','warning','info']
 * @param  string $message   message to be displayed
 */
if(!function_exists('flashMessage')) {
    function flashMessage($state, $title, $message)
    {
        Session::flash('state', $state);
        Session::flash('title', $title);
        Session::flash('message', $message);
    }
}


/**
 * Reduce String with given length
 *
 * @param String $string
 * @param Integer $length
 *
 * @return String $string
 */
if (!function_exists('truncateString')) {
    function truncateString($string,$length = 90)
    {
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length+1);
            $pos = strrpos($string, ' ');
            $string = substr($string, 0, ($pos > 0)? $pos : $length).'...';
        }
        return $string;
    }
}

/**
 * Get Site Base Url
 *
 * @return String $url Base url
 */
if (!function_exists('siteUrl')) {

    function siteUrl()
    {
        $global_settings_url = global_settings('site_url');
        $url = \App::runningInConsole() ? $global_settings_url : url('/');
        return $url;
    }
}


/**
 * Check Current Route is inside given array
 *
 * @param  String route names
 * @return boolean true|false
 */
if (!function_exists('isActiveRoute')) {

    function isActiveRoute()
    {
        $routes = func_get_args();
        return in_array(Route::currentRouteName(),$routes);
    }
}

/**
 * Check Given Request is from API or not
 *
 * @return Boolean
 */
if (!function_exists('isApiRequest')) {

    function isApiRequest()
    {
        return request()->segment(1) == 'api';
    }
}

/**
 * Check is admin panel or not
 *
 * @param string $hostUserId
 * @return Boolean
 */
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return Request::segment(1) == global_settings('admin_url');
    }
}

/**
 * Convert underscore_strings to camelCase (medial capitals).
 *
 * @param {string} $str
 *
 * @return {string}
 */
if (!function_exists('snakeToCamel')) {
    
    function snakeToCamel($str,$removeSpace = false) {
        // Remove underscores, capitalize words, squash.
        $camelCaseStr =  ucwords(str_replace('_', ' ', $str));
        if($removeSpace) {
            $camelCaseStr =  str_replace(' ', '', $camelCaseStr);
        }
        return $camelCaseStr;
    }
}


/**
 * Get Current User
 *
 */
if (!function_exists('getCurrentUser')) {
    function getCurrentUser()
    {
        $guard = 'user';
        if(request()->segment(1) == 'api' ||request()->segment(1) == 'admin') {
            $guard = request()->segment(1);
        }
        return \Auth::guard($guard)->user();
    }
}

/**
 * Get Current User ID
 *
 */
if (!function_exists('getCurrentUserId')) {
    function getCurrentUserId()
    {
        $user = getCurrentUser();
        return optional($user)->id;
    }
}

/**
 * Check Locale is arabic or not
 *
 */
if (!function_exists('isRtl')) {
    function isRtl()
    {
        return app()->getLocale() == 'ar';
    }
}

/**
 * Check given input is timestamp or not
 *
 * @param String|Timestamp $timestamp
 * @return Boolean
 */
if (!function_exists('isValidTimeStamp')) {
    function isValidTimeStamp($timestamp)
    {
        try {
            new DateTime('@'.$timestamp);
        }
        catch(\Exception $e) {
            return false;
        }
        return true;
    }
}

/**
 * Get Carbon Date Object from Given date or timestamp
 *
 * @param String|Timestamp $date
 * @return Object $date_obj  instance of Carbon\Carbon
 */
if (!function_exists('getDateObject')) {
    function getDateObject($date = '')
    {
        if($date == '') {
            $date_obj = Carbon::now();
        }
        else if(isValidTimeStamp($date)) {
            $date_obj = Carbon::createFromTimestamp($date);
        }
        else {
            $date_obj = Carbon::createFromTimestamp(strtotime($date));
        }
        return $date_obj;
    }
}


/**
 * Send Notification to User
 *
 * @return Array
 */
if (!function_exists('resolveAndSendNotification')) {
    function resolveAndSendNotification($functionName,...$args)
    {
        $notification_service = resolve("App\Services\NotificationService");
        $return_data = $notification_service->$functionName(...$args);
        return $return_data;
    }
}