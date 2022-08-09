<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('credentials')->truncate();

		DB::table('credentials')->insert([
			['name' => 'driver', 'value' => 'smtp','site' => 'EmailConfig'],
			['name' => 'host', 'value' => 'smtp.gmail.com','site' => 'EmailConfig'],
			['name' => 'port', 'value' => '587','site' => 'EmailConfig'],
			['name' => 'from_address', 'value' => 'shanmuga3demo@gmail.com','site' => 'EmailConfig'],
			['name' => 'from_name', 'value' => 'Indomie','site' => 'EmailConfig'],
			['name' => 'encryption', 'value' => 'tls','site' => 'EmailConfig'],
			['name' => 'username', 'value' => 'shanmuga3demo@gmail.com','site' => 'EmailConfig'],
			['name' => 'password', 'value' => 'hopmhwcwzivwdhyq','site' => 'EmailConfig'],

            ['name' => 'is_enabled','value' => '0','site' => 'ReCaptcha'],
            ['name' => 'version','value' => '2','site' => 'ReCaptcha'],
			['name' => 'site_key','value' => '6LcF1bUaAAAAAIFgygQFz4fDYIrB0LVK8FvfL6AG','site' => 'ReCaptcha'],
			['name' => 'secret_key','value' => '6LcF1bUaAAAAAG4NukEA1De87YO5ziWDzv8q9Wo3','site' => 'ReCaptcha'],
		]);
    }
}
