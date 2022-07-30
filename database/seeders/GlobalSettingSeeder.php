<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('global_settings')->truncate();
        
        DB::table('global_settings')->insert([
            ['name' => 'site_name', 'value' => 'World Cup'],
            ['name' => 'site_url', 'value' => ''],
            ['name' => 'version', 'value' => '1.0'],
            ['name' => 'starting_year', 'value' => date('Y')],
            ['name' => 'admin_url', 'value' => 'admin'],
            ['name' => 'timezone', 'value' => 'Asia/Kolkata'],
            ['name' => 'upload_driver', 'value' => '0'],
            ['name' => 'support_number', 'value' => '9876543210'],
            ['name' => 'support_email', 'value' => 'support@gmail.com'],
            ['name' => 'date_format', 'value' => '1'],
            ['name' => 'logo', 'value' => 'logo.png'],
            ['name' => 'logo_driver', 'value' => '0'],
            ['name' => 'favicon', 'value' => 'favicon.png'],
            ['name' => 'favicon_driver', 'value' => '0'],
            ['name' => 'head_code', 'value' => ''],
            ['name' => 'foot_code', 'value' => ''],
            ['name' => 'maintenance_mode_secret', 'value' => ''],
            ['name' => 'default_user_status', 'value' => 'active'],
            ['name' => 'backup_period', 'value' => 'never'],
            ['name' => 'copyright_link', 'value' => '#'],
            ['name' => 'copyright_text', 'value' => 'All Rights Reserved'],
            ['name' => 'font_script_url', 'value' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap'],
            ['name' => 'font_family', 'value' => '\'Poppins\', sans-serif'],
        ]);
    }
}
