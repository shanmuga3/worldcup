<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('metas')->delete();

		$currentDateTime = date('Y-m-d H:i:s');
		
		DB::table('metas')->insert([
			['route_name' => 'home','display_name' => '/', 'title' => '{SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'login','display_name' => 'login', 'title' => 'Login - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'register','display_name' => 'register', 'title' => 'Register - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'reset_password','display_name' => 'reset_password', 'title' => 'Reset Password - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'dashboard','display_name' => 'dashboard', 'title' => 'Dashboard - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'edit_profile','display_name' => 'edit_profile', 'title' => 'Edit Profile - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
			['route_name' => 'previous_guesses','display_name' => 'previous_guesses', 'title' => 'Previous Guesses - {SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
		]);
    }
}
