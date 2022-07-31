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
            array('name' => 'MAR- المغرب ', 'src' => 'morocco.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'COL - كولومبيا', 'src' => 'col.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'PAN - باناما', 'src' => 'pan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'JPN - اليابان', 'src' => 'japan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'TUN - تونس', 'src' => 'tunisia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ENG - إنجلترا', 'src' => 'england.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'BEL - بلجيكا', 'src' => 'belgium.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SWE - السويد', 'src' => 'swe.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'MEX - المكسيك', 'src' => 'mexico.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'KOR - كوريا الجنوبية', 'src' => 'south-korea.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'GER - ألمانيا', 'src' => 'germany.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SUI - سويسرا', 'src' => 'switzerland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SRB - صربيا', 'src' => 'serbia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'CRC - كوستاريكا', 'src' => 'costa-rica.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'BRA - البرازيل', 'src' => 'brazil.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'NGA - نيجيريا', 'src' => 'nga.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ISL    - آيسلندا', 'src' => 'isl.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'CRO - كرواتيا', 'src' => 'croatia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ARG - الأرجنتين', 'src' => 'argentina.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'PER – بيرو ', 'src' => 'per.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ESP - إسبانيا', 'src' => 'spain.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'IRN - إيران', 'src' => 'irn.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'AUS - أستراليا', 'src' => 'australia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'DEN – الدنمارك ', 'src' => 'denmark.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'FRA - فرنسا', 'src' => 'france.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'POL – بولندا ', 'src' => 'poland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'POR - البرتغال ', 'src' => 'portugal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'SEN – السينيغال ', 'src' => 'senegal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'EGY – مصر', 'src' => 'egy.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'KSA –  المملكة العربية السعودية', 'src' => 'saudiarabia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'RUS - روسيا', 'src' => 'rus.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'URU - أوروجواي', 'src' => 'uruguay.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'QAT - ﻗَﻄَﺮ', 'src' => 'qatar.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('name' => 'ECU', 'src' => 'ecuador.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
        ]);
	}
}
