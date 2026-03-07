<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CountriesTableSeeder::class,
            CitiesTableSeeder::class,
            DaysTableSeeder::class,
            NeighborhoodsTableSeeder::class,
            NationalitiesTableSeeder::class,
            UsersTableSeeder::class,
            PackageSeeder::class,
            SliderSeeder::class,
            NotificationSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
