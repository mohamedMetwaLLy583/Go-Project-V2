<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Neighborhood;
use App\Models\City;

class RiyadhRegionsSeeder extends Seeder
{
    public function run()
    {
        $riyadh = City::where('name_ar', 'like', '%الرياض%')->first();
        if (!$riyadh) {
            $riyadh = City::create([
                'country_id' => 1,
                'name_ar' => 'الرياض',
                'name_en' => 'Riyadh',
                'is_active' => true
            ]);
        }

        $regions = [
            [
                'name_ar' => 'شمال الرياض',
                'name_en' => 'North Riyadh',
                'neighborhoods' => [
                    ['name_ar' => 'الياسمين', 'name_en' => 'Al Yasmin'],
                    ['name_ar' => 'الملقا', 'name_en' => 'Al Malqa'],
                    ['name_ar' => 'الصحافة', 'name_en' => 'Al Sahafa'],
                    ['name_ar' => 'النرجس', 'name_en' => 'Al Narjis'],
                ]
            ],
            [
                'name_ar' => 'جنوب الرياض',
                'name_en' => 'South Riyadh',
                'neighborhoods' => [
                    ['name_ar' => 'العزيزية', 'name_en' => 'Al Aziziyah'],
                    ['name_ar' => 'الدار البيضاء', 'name_en' => 'Ad Dar Al Baida'],
                    ['name_ar' => 'الشفا', 'name_en' => 'Ash Shifa'],
                ]
            ],
            [
                'name_ar' => 'شرق الرياض',
                'name_en' => 'East Riyadh',
                'neighborhoods' => [
                    ['name_ar' => 'الروضة', 'name_en' => 'Ar Rawdah'],
                    ['name_ar' => 'النسيم', 'name_en' => 'An Naseem'],
                    ['name_ar' => 'السلي', 'name_en' => 'As Sulay'],
                ]
            ],
            [
                'name_ar' => 'غرب الرياض',
                'name_en' => 'West Riyadh',
                'neighborhoods' => [
                    ['name_ar' => 'طويق', 'name_en' => 'Tuwaiq'],
                    ['name_ar' => 'لبن', 'name_en' => 'Laban'],
                    ['name_ar' => 'العريجاء', 'name_en' => 'Al Uraija'],
                ]
            ],
        ];

        foreach ($regions as $rData) {
            $region = Region::create([
                'name_ar' => $rData['name_ar'],
                'name_en' => $rData['name_en'],
                'is_active' => true
            ]);

            foreach ($rData['neighborhoods'] as $nData) {
                Neighborhood::create([
                    'city_id' => $riyadh->id,
                    'region_id' => $region->id,
                    'name_ar' => $nData['name_ar'],
                    'name_en' => $nData['name_en'],
                    'is_active' => true
                ]);
            }
        }
    }
}
