<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GlobalSettingSeeder::class,
            CredentialSeeder::class,
            MetaSeeder::class,
            CountrySeeder::class,
            LanguageSeeder::class,
            LaravelEntrustSeeder::class,
            SocialMediaLinkSeeder::class,
            SliderSeeder::class,
            StaticPageSeeder::class,
        ]);

        $this->call([
            TeamSeeder::class,
        ]);
    }
}
