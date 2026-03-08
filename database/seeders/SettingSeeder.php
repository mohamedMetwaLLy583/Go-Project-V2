<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $safeNow = '2026-01-01 12:00:00';
        DB::table('settings')->insert([
            'app_commission' => '10', // نسبة عمولة التطبيق
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ]);
    }
}
