<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialMediaLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('social_media_links')->delete();

		DB::table('social_media_links')->insert([
			['name' => 'facebook', 'value' => 'https://www.facebook.com/'],
			['name' => 'instagram', 'value' => 'https://www.instagram.com/'],
			['name' => 'twitter', 'value' => 'https://twitter.com/'],
			['name' => 'linkedin', 'value' => 'https://www.linkedin.com/'],
			['name' => 'pinterest', 'value' => 'https://www.pinterest.com/'],
			['name' => 'youtube', 'value' => 'https://www.youtube.com/'],
			['name' => 'skype', 'value' => ''],
		]);
    }
}
