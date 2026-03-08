<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        // countries IDs
        $saudiId = DB::table('countries')->where('code', 'SA')->value('id');
        $egyptId = DB::table('countries')->where('code', 'EG')->value('id');

        // cities in Saudi Arabia
        $saudiCities = [
            ['name_ar' => 'الرياض', 'name_en' => 'Riyadh'],
            ['name_ar' => 'جدة', 'name_en' => 'Jeddah'],
            ['name_ar' => 'مكة المكرمة', 'name_en' => 'Makkah'],
            ['name_ar' => 'المدينة المنورة', 'name_en' => 'Madinah'],
            ['name_ar' => 'الدمام', 'name_en' => 'Dammam'],
            ['name_ar' => 'الطائف', 'name_en' => 'Taif'],
            ['name_ar' => 'تبوك', 'name_en' => 'Tabuk'],
            ['name_ar' => 'أبها', 'name_en' => 'Abha'],
        ];

        //  cities in Egypt
        $egyptCities = [
            ['name_ar' => 'القاهرة', 'name_en' => 'Cairo'],
            ['name_ar' => 'الإسكندرية', 'name_en' => 'Alexandria'],
            ['name_ar' => 'الجيزة', 'name_en' => 'Giza'],
            ['name_ar' => 'شرم الشيخ', 'name_en' => 'Sharm El Sheikh'],
            ['name_ar' => 'الأقصر', 'name_en' => 'Luxor'],
            ['name_ar' => 'أسوان', 'name_en' => 'Aswan'],
            ['name_ar' => 'بورسعيد', 'name_en' => 'Port Said'],
        ];

        $citiesData = [];
        $safeNow = '2026-01-01 12:00:00';

        foreach ($saudiCities as $city) {
            $citiesData[] = [
                'country_id' => $saudiId,
                'name_ar' => $city['name_ar'],
                'name_en' => $city['name_en'],
                'is_active' => true,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ];
        }

        foreach ($egyptCities as $city) {
            $citiesData[] = [
                'country_id' => $egyptId,
                'name_ar' => $city['name_ar'],
                'name_en' => $city['name_en'],
                'is_active' => true,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ];
        }

        DB::table('cities')->insert($citiesData);
    }
}
