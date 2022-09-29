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

        $this->app->singleton('Country', function() {
            return \App\Models\Country::get();
        });

        $this->app->singleton('Language', function() {
            return \App\Models\Language::get();
        });

        $this->app->singleton('Team', function() {
            return \App\Models\Team::get();
        });

        $this->app->singleton('DateFormat', function() {
            $path = app_path('Models/DateFormats.json');
            $date_formats = collect(json_decode(file_get_contents($path), true));
            return $date_formats;
        });

        $this->app->singleton('City', function() {
            return collect([
                ["id" => 1, "name" => "Ahad Al Masarihah / احد المسارحه"],
                ["id" => 2, "name" => "Aflaj / الافلاج"],
                ["id" => 3, "name" => "Hasa / الأحساء"],
                ["id" => 4, "name" => "Asyah / الأسياح"],
                ["id" => 5, "name" => "Al Bahah / الباحة"],
                ["id" => 5, "name" => "Bada'a / البدائع"],
                ["id" => 7, "name" => "Al Bukayriyah / البكيرية"],
                ["id" => 8, "name" => "Jubail / الجبيل"],
                ["id" => 9, "name" => "Al-Jumum / الجموم"],
                ["id" => 10, "name" => "Al Hait / الحائط"],
                ["id" => 11, "name" => "Al Henakiyah / الحناكية"],
                ["id" => 12, "name" => "Al Khobar / الخبر"],
                ["id" => 13, "name" => "Kharj / الخرج"],
                ["id" => 14, "name" => "Al Khurma / الخرمة"],
                ["id" => 15, "name" => "Khafji / الخفجي"],
                ["id" => 16, "name" => "Addayer / الدائر"],
                ["id" => 17, "name" => "Al Darb / الدرب"],
                ["id" => 18, "name" => "Diriyah / الدرعية"],
                ["id" => 19, "name" => "Dammam / الدمام"],
                ["id" => 20, "name" => "Dawadmi / الدوادمي"],
                ["id" => 21, "name" => "Alrass / الرس"],
                ["id" => 22, "name" => "Riyadh / الرياض"],
                ["id" => 23, "name" => "zulfi / الزلفي"],
                ["id" => 24, "name" => "Al Sulayyil / السليل"],
                ["id" => 25, "name" => "Taif / الطائف"],
                ["id" => 26, "name" => "Al Tuwal / الطوال"],
                ["id" => 27, "name" => "Al Aridhah / العارضة"],
                ["id" => 28, "name" => "Al Ardyat / العرضيات"],
                ["id" => 29, "name" => "Al ula / العلا"],
                ["id" => 30, "name" => "Qurayyat / القريات"],
                ["id" => 31, "name" => "Qatif / القطيف"],
                ["id" => 32, "name" => "Al Qunfudhah / القنفذة"],
                ["id" => 33, "name" => "Al-Quway'iyah / القويعية"],
                ["id" => 34, "name" => "laith / الليث"],
                ["id" => 35, "name" => "Majarda / المجاردة"],
                ["id" => 36, "name" => "Al Majma'ah / المجمعة"],
                ["id" => 37, "name" => "Almakhwah / المخواة"],
                ["id" => 38, "name" => "Medina / المدينة المنورة"],
                ["id" => 39, "name" => "Al Mithnab / المذنب"],
                ["id" => 40, "name" => "Al-Muzahmiya / المزاحمية"],
                ["id" => 41, "name" => "Mahd / المهد"],
                ["id" => 42, "name" => "Al Muwayh / المويه"],
                ["id" => 43, "name" => "Al Nabhaniyah / النبهانية"],
                ["id" => 44, "name" => "Nairyah / النعيرية"],
                ["id" => 45, "name" => "Al Namas / النماص"],
                ["id" => 46, "name" => "Al Wajh / الوجه"],
                ["id" => 47, "name" => "Abha / أبها"],
                ["id" => 48, "name" => "Abu Arish / أبو عريش"],
                ["id" => 49, "name" => "Ahad Rafidah / أحد رفيدة"],
                ["id" => 50, "name" => "Adham / أضم"],
                ["id" => 51, "name" => "Umluj / أملج"],
                ["id" => 52, "name" => "Bariq / بارق"],
                ["id" => 53, "name" => "Bahrah / بحرة"],
                ["id" => 54, "name" => "Badr / بدر"],
                ["id" => 55, "name" => "Buraydah / بريدة"],
                ["id" => 56, "name" => "Baqaa / بقعاء"],
                ["id" => 57, "name" => "Buqayq / بقيق"],
                ["id" => 58, "name" => "Baljurashi / بلجرشي"],
                ["id" => 59, "name" => "Balqrn / بلقرن"],
                ["id" => 50, "name" => "Bish / بيش"],
                ["id" => 61, "name" => "Bisha / بيشة"],
                ["id" => 62, "name" => "Tabuk / تبوك"],
                ["id" => 63, "name" => "Tathleeth / تثليث"],
                ["id" => 64, "name" => "Turbah / تربة"],
                ["id" => 65, "name" => "Tayma / تيماء"],
                ["id" => 66, "name" => "Jazan / جازان"],
                ["id" => 67, "name" => "Jeddah / جدة"],
                ["id" => 68, "name" => "Hail / حائل"],
                ["id" => 69, "name" => "Hafar Al-Batin / حفر الباطن"],
                ["id" => 70, "name" => "Howtat Bani Tamim / حوطة بني تميم"],
                ["id" => 71, "name" => "Khulais / خليص"],
                ["id" => 72, "name" => "Khamis Mushait / خميس مشيط"],
                ["id" => 73, "name" => "Khaibar / خيبر"],
                ["id" => 74, "name" => "Dumah Al Jandal / دومة الجندل"],
                ["id" => 75, "name" => "Rabigh / رابغ"],
                ["id" => 76, "name" => "Ras Tanura / رأس تنورة"],
                ["id" => 77, "name" => "Ragal Almaa / رجال المع"],
                ["id" => 78, "name" => "Rafha / رفحاء"],
                ["id" => 79, "name" => "Ranyah / رنية"],
                ["id" => 80, "name" => "Sarat Obeida / سراة عبيدة"],
                ["id" => 81, "name" => "Sakaka / سكاكا"],
                ["id" => 82, "name" => "Sharurah / شرورة"],
                ["id" => 83, "name" => "Shaqra / شقراء"],
                ["id" => 84, "name" => "samta / صامطة"],
                ["id" => 85, "name" => "Sabya / صبيا"],
                ["id" => 86, "name" => "Duba / ضباء"],
                ["id" => 87, "name" => "Damad / ضمد"],
                ["id" => 88, "name" => "Tabarjal / طبرجل"],
                ["id" => 89, "name" => "Turaif / طريف"],
                ["id" => 90, "name" => "Dhahran Al Janub / ظهران الجنوب"],
                ["id" => 91, "name" => "Arar / عرعر"],
                ["id" => 92, "name" => "Afif / عفيف"],
                ["id" => 93, "name" => "Unaizah / عنيزة"],
                ["id" => 94, "name" => "Qilwah / قلوة"],
                ["id" => 95, "name" => "Muhail / محايل"],
                ["id" => 96, "name" => "Mecca / مكة المكرمة"],
                ["id" => 97, "name" => "Maysan / ميسان"],
                ["id" => 98, "name" => "Najran / نجران"],
                ["id" => 99, "name" => "Wadi Al Dawasir / وادي الدواسر"],
                ["id" => 100, "name" => "Yanbu / ينبع"],
            ]);
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
