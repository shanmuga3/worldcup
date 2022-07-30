<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Collective\Html\FormBuilder;

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

        $this->app->singleton('FooterSocialMedia', function() {
            $social_media = resolve("SocialMediaLink");
            return $social_media->whereNotIn('name',['app_store','play_store'])->values();
        });

        $this->app->singleton('Credential', function() {
            return \App\Models\Credential::get();
        });

        $this->app->singleton('Meta', function() {
            return \App\Models\Meta::get();
        });
    }
}
