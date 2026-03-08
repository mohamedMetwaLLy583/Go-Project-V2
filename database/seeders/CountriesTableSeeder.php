<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $safeNow = '2026-01-01 12:00:00';
        DB::table('countries')->insert([
            [
                'name_ar' => 'المملكة العربية السعودية',
                'name_en' => 'Saudi Arabia',
                'code' => 'SA',
                'phone_code' => '+966',
                'currency' => 'SAR',
                'currency_symbol' => 'ر.س',
                'is_active' => true,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name_ar' => 'جمهورية مصر العربية',
                'name_en' => 'Egypt',
                'code' => 'EG',
                'phone_code' => '+20',
                'currency' => 'EGP',
                'currency_symbol' => 'ج.م',
                'is_active' => true,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
        ]);
    }
}