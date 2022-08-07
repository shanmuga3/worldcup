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
            array('short_name' => 'MAR', 'name' => '{"en":"Morocco","ar":"المغرب"}', 'image' => 'morocco.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'COL', 'name' => '{"en":"Colombia","ar":"كولومبيا"}', 'image' => 'col.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'PAN', 'name' => '{"en":"Panama","ar":"باناما"}', 'image' => 'pan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'JPN', 'name' => '{"en":"Japan","ar":"اليابان"}', 'image' => 'japan.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'TUN', 'name' => '{"en":"Tunisia","ar":"تونس"}', 'image' => 'tunisia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'ENG', 'name' => '{"en":"England","ar":"إنجلترا"}', 'image' => 'england.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'BEL', 'name' => '{"en":"Belgium","ar":"بلجيكا"}', 'image' => 'belgium.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'SWE', 'name' => '{"en":"Sweden","ar":"السويد"}', 'image' => 'swe.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'MEX', 'name' => '{"en":"Mexico","ar":"المكسيك"}', 'image' => 'mexico.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'KOR', 'name' => '{"en":"South Korea","ar":"كوريا الجنوبية"}', 'image' => 'south-korea.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'GER', 'name' => '{"en":"Germany","ar":"ألمانيا"}', 'image' => 'germany.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'SUI', 'name' => '{"en":"Switzerland","ar":"سويسرا"}', 'image' => 'switzerland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'SRB', 'name' => '{"en":"Serbia","ar":"صربيا"}', 'image' => 'serbia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'CRC', 'name' => '{"en":"Costa Rica","ar":"كوستاريكا"}', 'image' => 'costa-rica.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'BRA', 'name' => '{"en":"Brazil","ar":"البرازيل"}', 'image' => 'brazil.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'NGA', 'name' => '{"en":"Nigeria","ar":"نيجيريا"}', 'image' => 'nga.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'ISL', 'name' => '{"en":"Iceland","ar":"آيسلندا"}', 'image' => 'isl.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'CRO', 'name' => '{"en":"Croatia","ar":"كرواتيا"}', 'image' => 'croatia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'ARG', 'name' => '{"en":"Argentina","ar":"الأرجنتين"}', 'image' => 'argentina.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'PER', 'name' => '{"en":"Peru","ar":"بيرو"}', 'image' => 'per.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'ESP', 'name' => '{"en":"Spain","ar":"إسبانيا"}', 'image' => 'spain.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'IRN', 'name' => '{"en":"Iran","ar":"إيران"}', 'image' => 'irn.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'AUS', 'name' => '{"en":"Australia","ar":"أستراليا"}', 'image' => 'australia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'DEN', 'name' => '{"en":"Denmark ","ar":"الدنمارك "}', 'image' => 'denmark.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'FRA', 'name' => '{"en":"France","ar":"فرنسا"}', 'image' => 'france.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'POL', 'name' => '{"en":"Poland","ar":"بولندا"}', 'image' => 'poland.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'POR', 'name' => '{"en":"Portugal","ar":"البرتغال"}', 'image' => 'portugal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'SEN', 'name' => '{"en":"Senegal","ar":"السينيغال"}', 'image' => 'senegal.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'EGY', 'name' => '{"en":"Egypt","ar":"مصر"}', 'image' => 'egy.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'KSA', 'name' => '{"en":"Kingdom Saudi Arabia","ar":"المملكة العربية السعودية"}', 'image' => 'saudiarabia.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'RUS', 'name' => '{"en":"Russia","ar":"روسيا"}', 'image' => 'rus.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'URU', 'name' => '{"en":"Uruguay","ar":"أوروجواي"}', 'image' => 'uruguay.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'QAT', 'name' => '{"en":"Qatar","ar":"ﻗَﻄَﺮ"}', 'image' => 'qatar.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
            array('short_name' => 'ECU', 'name' => '{"en":"Ecuador","ar":"الاكوادور"}', 'image' => 'ecuador.png', 'upload_driver' => '0', 'created_at' => $currentDateTime,'updated_at' => $currentDateTime),
        ]);
	}
}
