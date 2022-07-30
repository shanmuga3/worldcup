<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('login_sliders')->delete();

		$currentDateTime = date('Y-m-d H:i:s');

		DB::table('login_sliders')->insert([
			['id' => 1, 'image' => 'admin_slider_1.jpg','order_id' => '1','upload_driver' => '0','created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
		]);
	}
}
