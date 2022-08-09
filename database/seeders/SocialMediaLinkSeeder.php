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
			['name' => 'facebook', 'value' => 'https://www.facebook.com/indomieksa'],
			['name' => 'instagram', 'value' => 'https://www.instagram.com/indomieksa/'],
			['name' => 'twitter', 'value' => 'https://twitter.com/@indomieksa'],
			['name' => 'linkedin', 'value' => ''],
			['name' => 'pinterest', 'value' => ''],
			['name' => 'youtube', 'value' => 'https://www.youtube.com/indomieksa'],
			['name' => 'skype', 'value' => ''],
			['name' => 'snapchat', 'value' => 'https://www.snapchat.com/add/indomieksa'],
			['name' => 'tiktok', 'value' => 'https://www.tiktok.com/@indomieksa'],
		]);
    }
}
