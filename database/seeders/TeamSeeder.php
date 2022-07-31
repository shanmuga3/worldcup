<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->delete();

		$currentDateTime = date('Y-m-d H:i:s');

		DB::table('teams')->insert([
            array('name' => 'MAR- المغرب ', 'image' => 'morocco.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'COL - كولومبيا', 'image' => 'col.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'PAN - باناما', 'image' => 'pan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'JPN - اليابان', 'image' => 'japan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'TUN - تونس', 'image' => 'tunisia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ENG - إنجلترا', 'image' => 'england.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'BEL - بلجيكا', 'image' => 'belgium.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SWE - السويد', 'image' => 'swe.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'MEX - المكسيك', 'image' => 'mexico.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'KOR - كوريا الجنوبية', 'image' => 'south-korea.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'GER - ألمانيا', 'image' => 'germany.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SUI - سويسرا', 'image' => 'switzerland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SRB - صربيا', 'image' => 'serbia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'CRC - كوستاريكا', 'image' => 'costa-rica.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'BRA - البرازيل', 'image' => 'brazil.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'NGA - نيجيريا', 'image' => 'nga.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ISL    - آيسلندا', 'image' => 'isl.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'CRO - كرواتيا', 'image' => 'croatia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ARG - الأرجنتين', 'image' => 'argentina.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'PER – بيرو ', 'image' => 'per.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ESP - إسبانيا', 'image' => 'spain.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'IRN - إيران', 'image' => 'irn.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'AUS - أستراليا', 'image' => 'australia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'DEN – الدنمارك ', 'image' => 'denmark.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'FRA - فرنسا', 'image' => 'france.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'POL – بولندا ', 'image' => 'poland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'POR - البرتغال ', 'image' => 'portugal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SEN – السينيغال ', 'image' => 'senegal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'EGY – مصر', 'image' => 'egy.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'KSA –  المملكة العربية السعودية', 'image' => 'saudiarabia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'RUS - روسيا', 'image' => 'rus.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'URU - أوروجواي', 'image' => 'uruguay.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'QAT - ﻗَﻄَﺮ', 'image' => 'qatar.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ECU', 'image' => 'ecuador.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
        ]);
	}
}
