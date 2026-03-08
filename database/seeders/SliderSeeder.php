<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $safeNow = '2026-01-01 12:00:00';
        $sliders = [
            [
                'image' => 'upload/sliders/slider1.jpg',
                'status' => 'active',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'image' => 'upload/sliders/slider2.jpg',
                'status' => 'active',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'image' => 'upload/sliders/slider3.jpg',
                'status' => 'active',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
        ];

        DB::table('sliders')->insert($sliders);
    }
}
