<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $nationalities = [
            ['name_ar' => 'سعودي', 'name_en' => 'Saudi'],
            ['name_ar' => 'مصري', 'name_en' => 'Egyptian'],
            ['name_ar' => 'أردني', 'name_en' => 'Jordanian'],
            ['name_ar' => 'سوري', 'name_en' => 'Syrian'],
            ['name_ar' => 'يمني', 'name_en' => 'Yemeni'],
            ['name_ar' => 'سوداني', 'name_en' => 'Sudanese'],
            ['name_ar' => 'فلسطيني', 'name_en' => 'Palestinian'],
            ['name_ar' => 'لبناني', 'name_en' => 'Lebanese'],
            ['name_ar' => 'كويتي', 'name_en' => 'Kuwaiti'],
            ['name_ar' => 'إماراتي', 'name_en' => 'Emirati'],
            ['name_ar' => 'قطري', 'name_en' => 'Qatari'],
            ['name_ar' => 'عماني', 'name_en' => 'Omani'],
            ['name_ar' => 'بحريني', 'name_en' => 'Bahraini'],
            ['name_ar' => 'عراقي', 'name_en' => 'Iraqi'],
            ['name_ar' => 'مغربي', 'name_en' => 'Moroccan'],
            ['name_ar' => 'تونسي', 'name_en' => 'Tunisian'],
            ['name_ar' => 'جزائري', 'name_en' => 'Algerian'],
            ['name_ar' => 'ليبي', 'name_en' => 'Libyan'],
            ['name_ar' => 'موريتاني', 'name_en' => 'Mauritanian'],
            ['name_ar' => 'صومالي', 'name_en' => 'Somali'],
            ['name_ar' => 'جيبوتي', 'name_en' => 'Djiboutian'],
            ['name_ar' => 'جزر القمر', 'name_en' => 'Comorian'],
            ['name_ar' => 'أفغاني', 'name_en' => 'Afghan'],
            ['name_ar' => 'باكستاني', 'name_en' => 'Pakistani'],
            ['name_ar' => 'هندي', 'name_en' => 'Indian'],
            ['name_ar' => 'بنجلاديشي', 'name_en' => 'Bangladeshi'],
            ['name_ar' => 'فلبيني', 'name_en' => 'Filipino'],
            ['name_ar' => 'إندونيسي', 'name_en' => 'Indonesian'],
            ['name_ar' => 'سريلانكي', 'name_en' => 'Sri Lankan'],
            ['name_ar' => 'نيبالي', 'name_en' => 'Nepali'],
            ['name_ar' => 'تركي', 'name_en' => 'Turkish'],
            ['name_ar' => 'إيراني', 'name_en' => 'Iranian'],
            ['name_ar' => 'أمريكي', 'name_en' => 'American'],
            ['name_ar' => 'كندي', 'name_en' => 'Canadian'],
            ['name_ar' => 'بريطاني', 'name_en' => 'British'],
            ['name_ar' => 'فرنسي', 'name_en' => 'French'],
            ['name_ar' => 'ألماني', 'name_en' => 'German'],
            ['name_ar' => 'إيطالي', 'name_en' => 'Italian'],
            ['name_ar' => 'إسباني', 'name_en' => 'Spanish'],
            ['name_ar' => 'روسي', 'name_en' => 'Russian'],
            ['name_ar' => 'صيني', 'name_en' => 'Chinese'],
            ['name_ar' => 'ياباني', 'name_en' => 'Japanese'],
            ['name_ar' => 'كوري جنوبي', 'name_en' => 'South Korean'],
            ['name_ar' => 'أسترالي', 'name_en' => 'Australian'],
        ];

        $nationalitiesData = [];
        foreach ($nationalities as $nationality) {
            $nationalitiesData[] = [
                'name_ar' => $nationality['name_ar'],
                'name_en' => $nationality['name_en'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('nationalities')->insert($nationalitiesData);
    }
}