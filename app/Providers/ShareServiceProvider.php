<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;

class ShareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $status = ['0' => Lang::get('messages.common.inactive'), '1' => Lang::get('messages.common.active')];
        View::share('status_array', $status);

        $yes_no = ['0' => Lang::get('messages.common.no'), '1' => Lang::get('messages.common.yes')];
        View::share('yes_no_array', $yes_no);

        $upload_drivers = ['0' => "Local"];
        View::share('upload_drivers', $upload_drivers);

        $valid_mimes = 'jpeg,jpg,png,webp';
        View::share('valid_mimes', $valid_mimes);

        $valid_video_mimes = 'mp4,webm';
        View::share('valid_video_mimes', $valid_video_mimes);

        if(env('DB_DATABASE') != '') {
            
            if(Schema::hasTable('global_settings')) {
                $this->siteSettings();
                $this->shareDateFormat();
            }

            if(Schema::hasTable('static_pages')) {
                $this->pages();
            }
        }
    }

    /**
     * Share Global Settings data to whole app
     *
     * @return void
     */
    protected function siteSettings()
    {
        $global_settings = resolve('GlobalSetting');
        if($global_settings->count()) {
            if($global_settings[1]->value == '' && @$_SERVER['HTTP_HOST'] && !\App::runningInConsole()) {
                $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $url  = $protocol.$_SERVER['HTTP_HOST'];
                $url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
                \App\Models\GlobalSetting::where('name','site_url')->update(['value' =>  $url]);
            }

            View::share('site_name', global_settings('site_name'));
            View::share('site_url', siteUrl());
            View::share('version', global_settings('version'));
            View::share('version', \Str::random(4)); // Load All JS & CSS without Cache
            
            if(!defined('SITE_NAME')) {
                define('SITE_NAME', global_settings('site_name'));
            }

            if(!defined("DELETE_STORAGE")) {
                $delete_storage = env("DELETE_STORAGE",true) == true;
                define("DELETE_STORAGE",$delete_storage);
            }

            if(!defined("MAIL_DRIVERS")) {
                define("MAIL_DRIVERS",["smtp" => "SMTP", "sendmail" => "Send Mail (Local)"]);
            }

            $site_logo = $this->getImageUrl('logo');
            $favicon = $this->getImageUrl('favicon');

            View::share('site_logo', $site_logo);
            View::share('favicon', $favicon);
        }
    }

    /**
     * Share Static Page data to whole app
     *
     * @return void
     */
    protected function pages()
    {
        if(!defined('FOOTER_SECTIONS')) {
            return false;
        }
        $pages = resolve("StaticPage")->where('status',1)->where('in_footer',1);
        $footer_sections = array();
        foreach (FOOTER_SECTIONS as $key => $section) {
            $footer_data = $pages->where('under_section',$key);
            if($footer_data->count() || $key == 'about') {
                $footer_sections[$section] = $footer_data;
            }
        }
        View::share('footer_sections', $footer_sections);

        $agree_pages = resolve("StaticPage")->where(
            'status',1)->where('must_agree',1);
        View::share('agree_pages', $agree_pages);
    }

    /**
     * Share country data to whole app
     *
     * @return void
     */
    protected function country()
    {
        $country = resolve('Country');
        $country_list = $country->pluck('full_name','name');
        $default_country_code = optional(resolve("Country")->first())->name ?? 'IN';
        View::share('default_country_code', $default_country_code);
        View::share('country_list', $country_list);
    }

    /**
     * Share Currency data to whole app
     *
     * @return void
     */
    protected function currency()
    {
        $currency = resolve('Currency')->where('status','1');
        $currency_list = $currency->pluck('code','code');
        View::share('currency_list', $currency_list);
    }

    /**
     * Share Language data to whole app
     *
     * @return void
     */
    protected function languages()
    {
        $languages = resolve('Language');
        $language_list = $languages->where('status','1')->where('is_translatable',1)->pluck('name','short_name');
        View::share('language_list', $language_list);
        $language_list = $languages->where('status','1')->where('is_translatable','1')->pluck('name','short_name');
        View::share('translatable_languages', $language_list);
    }

    /**
     * Set Application Date Format 
     *
     * @return void
     */
    protected function shareDateFormat()
    {
        view()->share('date_format', "d/m/Y");
        if(!defined('DATE_FORMAT')) {
            define('DATE_FORMAT', "d/m/Y");
        }

        view()->share('time_format','h:i A');
        if(!defined('TIME_FORMAT')) {
            define('TIME_FORMAT', 'h:i A');
        }
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
        $image_data['name'] = $global_setting->value;
        $image_data['version_based'] = true;
        $image_data['path'] = $global_setting->filePath;

        return $handler->fetch($image_data);
    }
}
