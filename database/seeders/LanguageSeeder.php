<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('languages')->delete();

		DB::table('languages')->insert([
			['code' => 'ar', 'name' => 'العربية'],
			['code' => 'en', 'name' => 'English'],
		]);
    }
}
