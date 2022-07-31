<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCollectionMacro();

        // Load All helper files
        foreach (glob(app_path() . '/Helpers/*.php') as $file) {
            require_once($file);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $this->registerBladeDirectives();

        if(env('DB_DATABASE') != '') {
            if(Schema::hasTable('global_settings')) {
                $this->bindModels();
                $this->globalSettings();
            }

            if(Schema::hasTable('credentials')) {
                $this->setEmailConfig();
            }
        }
    }

    /**
     * Register Collection Macro to update Append attributes run time
     *
     * @return void
     */
    protected function registerCollectionMacro()
    {
        Collection::macro('setAppends', function ($attributes) {
            return $this->each->setAppends($attributes);
        });

        Collection::macro('activeOnly', function () {
            return $this->where('status','1')->values();
        });
    }

    /**
     * Register Collective Form Macro to day,month and year dropdown with attributes
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        // Blade Directive to check Permission of current Admin User
        \Blade::if('checkPermission', function($permission) {
            return auth()->guard('admin')->user()->can($permission);
        });

        // Blade Directive to check Given Id is currently login user or not
        \Blade::if('checkUser', function($id) {
            return auth()->id() === $id;
        });
    }

    /**
     * Bind Commonly Used Models
     *
     * @return void
     */
    protected function bindModels()
    {
        $this->app->singleton('GlobalSetting', function() {
            return \App\Models\GlobalSetting::get();
        });

        $this->app->singleton('StaticPage', function() {
            return \App\Models\StaticPage::get();
        });

        $this->app->singleton('SocialMediaLink', function() {
            return \App\Models\SocialMediaLink::get();
        });

        $this->app->singleton('Credential', function() {
            return \App\Models\Credential::get();
        });

        $this->app->singleton('Meta', function() {
            return \App\Models\Meta::get();
        });

        $this->app->singleton('DateFormat', function() {
            $path = app_path('Models/DateFormats.json');
            $date_formats = collect(json_decode(file_get_contents($path), true));
            return $date_formats;
        });
    }

    /**
     * Default Configuration from Global Settings
     *
     * @return void
     */
    protected function globalSettings()
    {
        $upload_drivers = ['0' => 'Local','1' => 'Cloudinary'];
        View::share('upload_drivers', $upload_drivers);

        $global_settings = resolve('GlobalSetting');

        $upload_drivers = View::shared('upload_drivers');
        $upload_driver = $upload_drivers[global_settings('upload_driver')] ?? 'Local';
        $image_handler = 'App\Services\ImageHandlers\\'.$upload_driver.'ImageHandler';
        $this->app->singleton('App\Contracts\ImageHandleInterface', $image_handler);

        $timezone = global_settings('timezone') != '' ? global_settings('timezone') : "UTC";
        Config::set('app.timezone',$timezone);
        date_default_timezone_set($timezone);
    }

    /**
     * Update Email Configuration
     *
     * @return void
     */
    protected function setEmailConfig()
    {
        $mail_config = $default_config = Config::get('mail');
        $mail_config['default'] = credentials('driver','EmailConfig');
        $mail_config['from'] = [
            'address' => credentials('from_address','EmailConfig'),
            'name' => credentials('from_name','EmailConfig')
        ];
        $smtp_conig = [
            'host' => credentials('host','EmailConfig'),
            'port' => credentials('port','EmailConfig'),
            'encryption' => credentials('encryption','EmailConfig'),
            'username' => credentials('username','EmailConfig'),
            'password' => credentials('password','EmailConfig'),
        ];
        $mail_config['mailers']['smtp'] = array_merge($default_config['mailers']['smtp'],$smtp_conig);

        Config::set('mail',$mail_config);
    }
}
