<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'name' => 'الباقة الأساسية',
                'price' => 500,
                'duration' => 1,
                'duration_unit' => 'month',
                'features' => json_encode([
                    'خدمة 1',
                    'خدمة 2',
                    'خدمة 3'
                ]),
                'status' => 'active',
                'is_popular' => true,
                'sort_order' => 1,
                'investment_amount' => null,
                'coins' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'الباقة الفضية',
                'price' => 1200,
                'duration' => 2,
                'duration_unit' => 'month',
                'features' => json_encode([
                    'خدمة 1',
                    'خدمة 2',
                    'خدمة 3'
                ]),
                'status' => 'active',
                'sort_order' => 2,
                'is_popular' => false,
                'investment_amount' => 50,
                'coins' => 250,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'الباقة الذهبية',
                'price' => 4000,
                'duration' => 3,
                'duration_unit' => 'month',
                'features' => json_encode([
                    'خدمة 1',
                    'خدمة 2',
                    'خدمة 3'
                ]),
                'status' => 'active',
                'sort_order' => 3,
                'is_popular' => false,
                'investment_amount' => 100,
                'coins' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('packages')->insert($packages);
    }
}
