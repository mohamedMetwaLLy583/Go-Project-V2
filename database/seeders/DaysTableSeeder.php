<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysTableSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            [
                'name_ar' => 'السبت',
                'name_en' => 'Saturday',
                'short_name_ar' => 'سب',
                'short_name_en' => 'Sat',
                'order' => 1,
            ],
            [
                'name_ar' => 'الأحد',
                'name_en' => 'Sunday',
                'short_name_ar' => 'أح',
                'short_name_en' => 'Sun',
                'order' => 2,
            ],
            [
                'name_ar' => 'الإثنين',
                'name_en' => 'Monday',
                'short_name_ar' => 'إث',
                'short_name_en' => 'Mon',
                'order' => 3,
            ],
            [
                'name_ar' => 'الثلاثاء',
                'name_en' => 'Tuesday',
                'short_name_ar' => 'ثل',
                'short_name_en' => 'Tue',
                'order' => 4,
            ],
            [
                'name_ar' => 'الأربعاء',
                'name_en' => 'Wednesday',
                'short_name_ar' => 'أر',
                'short_name_en' => 'Wed',
                'order' => 5,
            ],
            [
                'name_ar' => 'الخميس',
                'name_en' => 'Thursday',
                'short_name_ar' => 'خم',
                'short_name_en' => 'Thu',
                'order' => 6,
            ],
            [
                'name_ar' => 'الجمعة',
                'name_en' => 'Friday',
                'short_name_ar' => 'جم',
                'short_name_en' => 'Fri',
                'order' => 7,
            ]
        ];

        $daysData = [];
        $safeNow = '2026-01-01 12:00:00';
        foreach ($days as $day) {
            $daysData[] = [
                'name_ar' => $day['name_ar'],
                'name_en' => $day['name_en'],
                'short_name_ar' => $day['short_name_ar'],
                'short_name_en' => $day['short_name_en'],
                'order' => $day['order'],
                'is_active' => true,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ];
        }

        DB::table('days')->insert($daysData);
    }
}
