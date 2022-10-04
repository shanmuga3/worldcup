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
                ["id" => 1, "name_en" => "Ahad Al Masarihah", "name_ar" => "احد المسارحه"],
                ["id" => 2, "name_en" => "Aflaj", "name_ar" => "الافلاج"],
                ["id" => 3, "name_en" => "Hasa", "name_ar" => "الأحساء"],
                ["id" => 4, "name_en" => "Asyah", "name_ar" => "الأسياح"],
                ["id" => 5, "name_en" => "Al Bahah", "name_ar" => "الباحة"],
                ["id" => 5, "name_en" => "Bada'a", "name_ar" => "البدائع"],
                ["id" => 7, "name_en" => "Al Bukayriyah", "name_ar" => "البكيرية"],
                ["id" => 8, "name_en" => "Jubail", "name_ar" => "الجبيل"],
                ["id" => 9, "name_en" => "Al-Jumum", "name_ar" => "الجموم"],
                ["id" => 10, "name_en" => "Al Hait", "name_ar" => "الحائط"],
                ["id" => 11, "name_en" => "Al Henakiyah", "name_ar" => "الحناكية"],
                ["id" => 12, "name_en" => "Al Khobar", "name_ar" => "الخبر"],
                ["id" => 13, "name_en" => "Kharj", "name_ar" => "الخرج"],
                ["id" => 14, "name_en" => "Al Khurma", "name_ar" => "الخرمة"],
                ["id" => 15, "name_en" => "Khafji", "name_ar" => "الخفجي"],
                ["id" => 16, "name_en" => "Addayer", "name_ar" => "الدائر"],
                ["id" => 17, "name_en" => "Al Darb", "name_ar" => "الدرب"],
                ["id" => 18, "name_en" => "Diriyah", "name_ar" => "الدرعية"],
                ["id" => 19, "name_en" => "Dammam", "name_ar" => "الدمام"],
                ["id" => 20, "name_en" => "Dawadmi", "name_ar" => "الدوادمي"],
                ["id" => 21, "name_en" => "Alrass", "name_ar" => "الرس"],
                ["id" => 22, "name_en" => "Riyadh", "name_ar" => "الرياض"],
                ["id" => 23, "name_en" => "zulfi", "name_ar" => "الزلفي"],
                ["id" => 24, "name_en" => "Al Sulayyil", "name_ar" => "السليل"],
                ["id" => 25, "name_en" => "Taif", "name_ar" => "الطائف"],
                ["id" => 26, "name_en" => "Al Tuwal", "name_ar" => "الطوال"],
                ["id" => 27, "name_en" => "Al Aridhah", "name_ar" => "العارضة"],
                ["id" => 28, "name_en" => "Al Ardyat", "name_ar" => "العرضيات"],
                ["id" => 29, "name_en" => "Al ula", "name_ar" => "العلا"],
                ["id" => 30, "name_en" => "Qurayyat", "name_ar" => "القريات"],
                ["id" => 31, "name_en" => "Qatif", "name_ar" => "القطيف"],
                ["id" => 32, "name_en" => "Al Qunfudhah", "name_ar" => "القنفذة"],
                ["id" => 33, "name_en" => "Al-Quway'iyah", "name_ar" => "القويعية"],
                ["id" => 34, "name_en" => "laith", "name_ar" => "الليث"],
                ["id" => 35, "name_en" => "Majarda", "name_ar" => "المجاردة"],
                ["id" => 36, "name_en" => "Al Majma'ah", "name_ar" => "المجمعة"],
                ["id" => 37, "name_en" => "Almakhwah", "name_ar" => "المخواة"],
                ["id" => 38, "name_en" => "Medina", "name_ar" => "المدينة المنورة"],
                ["id" => 39, "name_en" => "Al Mithnab", "name_ar" => "المذنب"],
                ["id" => 40, "name_en" => "Al-Muzahmiya", "name_ar" => "المزاحمية"],
                ["id" => 41, "name_en" => "Mahd", "name_ar" => "المهد"],
                ["id" => 42, "name_en" => "Al Muwayh", "name_ar" => "المويه"],
                ["id" => 43, "name_en" => "Al Nabhaniyah", "name_ar" => "النبهانية"],
                ["id" => 44, "name_en" => "Nairyah", "name_ar" => "النعيرية"],
                ["id" => 45, "name_en" => "Al Namas", "name_ar" => "النماص"],
                ["id" => 46, "name_en" => "Al Wajh", "name_ar" => "الوجه"],
                ["id" => 47, "name_en" => "Abha", "name_ar" => "أبها"],
                ["id" => 48, "name_en" => "Abu Arish", "name_ar" => "أبو عريش"],
                ["id" => 49, "name_en" => "Ahad Rafidah", "name_ar" => "أحد رفيدة"],
                ["id" => 50, "name_en" => "Adham", "name_ar" => "أضم"],
                ["id" => 51, "name_en" => "Umluj", "name_ar" => "أملج"],
                ["id" => 52, "name_en" => "Bariq", "name_ar" => "بارق"],
                ["id" => 53, "name_en" => "Bahrah", "name_ar" => "بحرة"],
                ["id" => 54, "name_en" => "Badr", "name_ar" => "بدر"],
                ["id" => 55, "name_en" => "Buraydah", "name_ar" => "بريدة"],
                ["id" => 56, "name_en" => "Baqaa", "name_ar" => "بقعاء"],
                ["id" => 57, "name_en" => "Buqayq", "name_ar" => "بقيق"],
                ["id" => 58, "name_en" => "Baljurashi", "name_ar" => "بلجرشي"],
                ["id" => 59, "name_en" => "Balqrn", "name_ar" => "بلقرن"],
                ["id" => 50, "name_en" => "Bish", "name_ar" => "بيش"],
                ["id" => 61, "name_en" => "Bisha", "name_ar" => "بيشة"],
                ["id" => 62, "name_en" => "Tabuk", "name_ar" => "تبوك"],
                ["id" => 63, "name_en" => "Tathleeth", "name_ar" => "تثليث"],
                ["id" => 64, "name_en" => "Turbah", "name_ar" => "تربة"],
                ["id" => 65, "name_en" => "Tayma", "name_ar" => "تيماء"],
                ["id" => 66, "name_en" => "Jazan", "name_ar" => "جازان"],
                ["id" => 67, "name_en" => "Jeddah", "name_ar" => "جدة"],
                ["id" => 68, "name_en" => "Hail", "name_ar" => "حائل"],
                ["id" => 69, "name_en" => "Hafar Al-Batin", "name_ar" => "حفر الباطن"],
                ["id" => 70, "name_en" => "Howtat Bani Tamim", "name_ar" => "حوطة بني تميم"],
                ["id" => 71, "name_en" => "Khulais", "name_ar" => "خليص"],
                ["id" => 72, "name_en" => "Khamis Mushait", "name_ar" => "خميس مشيط"],
                ["id" => 73, "name_en" => "Khaibar", "name_ar" => "خيبر"],
                ["id" => 74, "name_en" => "Dumah Al Jandal", "name_ar" => "دومة الجندل"],
                ["id" => 75, "name_en" => "Rabigh", "name_ar" => "رابغ"],
                ["id" => 76, "name_en" => "Ras Tanura", "name_ar" => "رأس تنورة"],
                ["id" => 77, "name_en" => "Ragal Almaa", "name_ar" => "رجال المع"],
                ["id" => 78, "name_en" => "Rafha", "name_ar" => "رفحاء"],
                ["id" => 79, "name_en" => "Ranyah", "name_ar" => "رنية"],
                ["id" => 80, "name_en" => "Sarat Obeida", "name_ar" => "سراة عبيدة"],
                ["id" => 81, "name_en" => "Sakaka", "name_ar" => "سكاكا"],
                ["id" => 82, "name_en" => "Sharurah", "name_ar" => "شرورة"],
                ["id" => 83, "name_en" => "Shaqra", "name_ar" => "شقراء"],
                ["id" => 84, "name_en" => "samta", "name_ar" => "صامطة"],
                ["id" => 85, "name_en" => "Sabya", "name_ar" => "صبيا"],
                ["id" => 86, "name_en" => "Duba", "name_ar" => "ضباء"],
                ["id" => 87, "name_en" => "Damad", "name_ar" => "ضمد"],
                ["id" => 88, "name_en" => "Tabarjal", "name_ar" => "طبرجل"],
                ["id" => 89, "name_en" => "Turaif", "name_ar" => "طريف"],
                ["id" => 90, "name_en" => "Dhahran Al Janub", "name_ar" => "ظهران الجنوب"],
                ["id" => 91, "name_en" => "Arar", "name_ar" => "عرعر"],
                ["id" => 92, "name_en" => "Afif", "name_ar" => "عفيف"],
                ["id" => 93, "name_en" => "Unaizah", "name_ar" => "عنيزة"],
                ["id" => 94, "name_en" => "Qilwah", "name_ar" => "قلوة"],
                ["id" => 95, "name_en" => "Muhail", "name_ar" => "محايل"],
                ["id" => 96, "name_en" => "Mecca", "name_ar" => "مكة المكرمة"],
                ["id" => 97, "name_en" => "Maysan", "name_ar" => "ميسان"],
                ["id" => 98, "name_en" => "Najran", "name_ar" => "نجران"],
                ["id" => 99, "name_en" => "Wadi Al Dawasir", "name_ar" => "وادي الدواسر"],
                ["id" => 100, "name_en" => "Yanbu", "name_ar" => "ينبع"],
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
