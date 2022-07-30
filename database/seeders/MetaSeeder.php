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
		
		$id = 1;
		DB::table('metas')->insert([
			['id' => $id++, 'route_name' => 'home','display_name' => '/', 'title' => '{SITE_NAME}', 'description' => NULL, 'created_at' => $currentDateTime, 'updated_at' => $currentDateTime],
		]);
    }
}
