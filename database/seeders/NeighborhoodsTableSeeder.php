<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeighborhoodsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get city IDs
        $madinaId = DB::table('cities')->where('name_ar', 'المدينة المنورة')->value('id');
        $jeddahId = DB::table('cities')->where('name_ar', 'جدة')->value('id');
        $riyadhId = DB::table('cities')->where('name_ar', 'الرياض')->value('id');
        $cairoId = DB::table('cities')->where('name_ar', 'القاهرة')->value('id');
        
        $neighborhoods = [

            // المدينة المنورة
            ['city_id' => $madinaId, 'name_ar' => 'حي الملز', 'name_en' => 'Al Malaz', 'direction' => 'north'],
            ['city_id' => $madinaId, 'name_ar' => 'حي العوالي', 'name_en' => 'Al Awali', 'direction' => 'south'],
            ['city_id' => $madinaId, 'name_ar' => 'حي الساحة', 'name_en' => 'Al Saha', 'direction' => 'east'],
            
            // جدة
            ['city_id' => $jeddahId, 'name_ar' => 'حي البديعية', 'name_en' => 'Al Badiyah', 'direction' => 'north'],
            ['city_id' => $jeddahId, 'name_ar' => 'حي السلامة', 'name_en' => 'Al Salamah', 'direction' => 'west'],
            ['city_id' => $jeddahId, 'name_ar' => 'حي النعيم', 'name_en' => 'Al Naeem', 'direction' => 'east'],
            
            // الرياض
            ['city_id' => $riyadhId, 'name_ar' => 'حي الملز', 'name_en' => 'Al Malaz', 'direction' => 'south'],
            ['city_id' => $riyadhId, 'name_ar' => 'حي العليا', 'name_en' => 'Al Olaya', 'direction' => 'north'],
            
            // القاهرة
            ['city_id' => $cairoId, 'name_ar' => 'حي مصر الجديدة', 'name_en' => 'New Cairo', 'direction' => 'east'],
            ['city_id' => $cairoId, 'name_ar' => 'حي المعادي', 'name_en' => 'Maadi', 'direction' => 'south'],
            ['city_id' => $cairoId, 'name_ar' => 'حي النزهة', 'name_en' => 'Al Nozha', 'direction' => 'north'],
        ];
        
        $neighborhoodsData = [];
        $safeNow = '2026-01-01 12:00:00';
        foreach ($neighborhoods as $neighborhood) {
            $neighborhoodsData[] = [
                'city_id'   => $neighborhood['city_id'],
                'name_ar'   => $neighborhood['name_ar'],
                'name_en'   => $neighborhood['name_en'],
                'direction' => $neighborhood['direction'], 
                'is_active' => true,
                'created_at'=> $safeNow,
                'updated_at'=> $safeNow,
            ];
        }
        
        DB::table('neighborhoods')->insert($neighborhoodsData);
    }
}