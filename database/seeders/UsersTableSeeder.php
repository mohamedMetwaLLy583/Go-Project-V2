<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $safeNow = '2026-01-01 12:00:00';
        $saudiNationalityId = DB::table('nationalities')->where('name_ar', 'سعودي')->value('id');
        $egyptianNationalityId = DB::table('nationalities')->where('name_ar', 'مصري')->value('id');

        // 1. أدمن (type = 1)
        $admins = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'phone' => '0501234567',
                'age' => 35,
                'nationality_id' => $saudiNationalityId,
                'type' => 1, // Admin
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/1/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ]
        ];

        // 2. سواقين (type = 2)
        $drivers = [
            // سواقين سعوديين
            [
                'name' => 'خالد السعدي',
                'email' => 'driver1@example.com',
                'phone' => '0551111111',
                'age' => 28,
                'nationality_id' => $saudiNationalityId,
                'type' => 2, // Driver
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/2/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'فهد القحطاني',
                'email' => 'driver2@example.com',
                'phone' => '0552222222',
                'age' => 32,
                'nationality_id' => $saudiNationalityId,
                'type' => 2, // Driver
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/3/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'عبدالله الحربي',
                'email' => 'driver3@example.com',
                'phone' => '0553333333',
                'age' => 30,
                'nationality_id' => $saudiNationalityId,
                'type' => 2, // Driver
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/4/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],

            // سواقين مصريين
            [
                'name' => 'محمود أحمد',
                'email' => 'driver4@example.com',
                'phone' => '01111111111',
                'age' => 34,
                'nationality_id' => $egyptianNationalityId,
                'type' => 2, // Driver
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/5/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'علي محسن',
                'email' => 'driver5@example.com',
                'phone' => '01222222222',
                'age' => 29,
                'nationality_id' => $egyptianNationalityId,
                'type' => 2, // Driver
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/6/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
        ];

        // 3. مستخدمين عاديين (type = 3)
        $users = [
            [
                'name' => 'محمد أحمد',
                'email' => 'user1@example.com',
                'phone' => '0567777777',
                'age' => 25,
                'nationality_id' => $saudiNationalityId,
                'type' => 3, // User
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/7/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'نورة عبدالله',
                'email' => 'user2@example.com',
                'phone' => '0568888888',
                'age' => 27,
                'nationality_id' => $saudiNationalityId,
                'type' => 3, // User
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/8/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'فاطمة خالد',
                'email' => 'user3@example.com',
                'phone' => '0569999999',
                'age' => 22,
                'nationality_id' => $saudiNationalityId,
                'type' => 3, // User
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/9/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'منى السيد',
                'email' => 'user4@example.com',
                'phone' => '01012345678',
                'age' => 26,
                'nationality_id' => $egyptianNationalityId,
                'type' => 3, // User
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/10/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
            [
                'name' => 'هدى أحمد',
                'email' => 'user5@example.com',
                'phone' => '01087654321',
                'age' => 24,
                'nationality_id' => $egyptianNationalityId,
                'type' => 3, // User
                'password' => Hash::make('123456789'),
                'email_verified_at' => $safeNow,
                'profile_picture' => 'upload/users/11/profile/profile_1771081076.jpg',
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ],
        ];

        // دمج جميع المستخدمين
        $allUsers = array_merge($admins, $drivers, $users);

        DB::table('users')->insert($allUsers);

        // إضافة بيانات التوفر للسواقين
        $this->addDriverAvailability();

        // إضافة صور السيارات للسواقين
        $this->addDriverImages();
    }

    private function addDriverAvailability(): void
    {
        // آيدي الأحيان
        $malazMadinaId = DB::table('neighborhoods')
            ->join('cities', 'neighborhoods.city_id', '=', 'cities.id')
            ->where('neighborhoods.name_ar', 'حي الملز')
            ->where('cities.name_ar', 'المدينة المنورة')
            ->value('neighborhoods.id');

        $badiyahJeddahId = DB::table('neighborhoods')
            ->join('cities', 'neighborhoods.city_id', '=', 'cities.id')
            ->where('neighborhoods.name_ar', 'حي البديعية')
            ->where('cities.name_ar', 'جدة')
            ->value('neighborhoods.id');

        $malazRiyadhId = DB::table('neighborhoods')
            ->join('cities', 'neighborhoods.city_id', '=', 'cities.id')
            ->where('neighborhoods.name_ar', 'حي الملز')
            ->where('cities.name_ar', 'الرياض')
            ->value('neighborhoods.id');

        // آيدي الأيام
        $saturdayId = DB::table('days')->where('name_ar', 'السبت')->value('id');
        $sundayId = DB::table('days')->where('name_ar', 'الأحد')->value('id');
        $mondayId = DB::table('days')->where('name_ar', 'الإثنين')->value('id');

        // سواقين (آيدي أول 5 سواق)
        $driverIds = DB::table('users')->where('type', 2)->limit(5)->pluck('id')->toArray();

        // بيانات التوفر للسواقين
        $availabilityData = [];

        // السائق 1: خالد السعدي (يمثل الصورة الأصلية)
        $availabilityData[] = [
            'driver_id' => $driverIds[0],
            'neighborhood_id' => $malazMadinaId,
            'day_id' => $saturdayId,
            'start_time' => '08:00:00',
            'end_time' => '18:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        $availabilityData[] = [
            'driver_id' => $driverIds[0],
            'neighborhood_id' => $malazMadinaId,
            'day_id' => $sundayId,
            'start_time' => '08:00:00',
            'end_time' => '18:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        $availabilityData[] = [
            'driver_id' => $driverIds[0],
            'neighborhood_id' => $badiyahJeddahId,
            'day_id' => $saturdayId,
            'start_time' => '06:00:00',
            'end_time' => '18:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        // السائق 2: فهد القحطاني
        $availabilityData[] = [
            'driver_id' => $driverIds[1],
            'neighborhood_id' => $malazRiyadhId,
            'day_id' => $saturdayId,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        $availabilityData[] = [
            'driver_id' => $driverIds[1],
            'neighborhood_id' => $malazRiyadhId,
            'day_id' => $sundayId,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        // السائق 3: عبدالله الحربي (فترتين في اليوم)
        $availabilityData[] = [
            'driver_id' => $driverIds[2],
            'neighborhood_id' => $malazMadinaId,
            'day_id' => $saturdayId,
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        $availabilityData[] = [
            'driver_id' => $driverIds[2],
            'neighborhood_id' => $malazMadinaId,
            'day_id' => $saturdayId,
            'start_time' => '16:00:00',
            'end_time' => '20:00:00',
            'is_active' => true,
            'created_at' => $safeNow,
            'updated_at' => $safeNow,
        ];

        if (!empty($availabilityData)) {
            DB::table('driver_availability')->insert($availabilityData);
        }
    }

    private function addDriverImages(): void
    {
        $driverIds = DB::table('users')->where('type', 2)->pluck('id');

        $images = [];

        foreach ($driverIds as $driverId) {
            for ($i = 1; $i <= 6; $i++) {
                $images[] = [
                    'user_id' => $driverId,
                    'image_path' => "upload/users/{$driverId}/car/car_{$i}_1771081772.jpg",
                    'created_at' => $safeNow,
                    'updated_at' => $safeNow,
                ];
            }
        }

        DB::table('car_images')->insert($images);
    }
}
