<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $safeNow = '2026-01-01 12:00:00';
        // جلب المستخدمين
        $users = User::all();

        foreach ($users as $user) {
            // إشعارات عامة
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'title' => 'مرحباً بك في التطبيق',
                'message' => 'شكراً لانضمامك إلينا. نتمنى لك تجربة ممتعة!',
                'data' => json_encode(['action' => 'welcome']),
                'is_read' => false,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ]);

            // عرض خاص
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'title' => 'عرض خاص 🎉',
                'message' => 'احصل على خصم 20% على أول باقة تشترك فيها',
                'data' => json_encode(['discount' => 20, 'code' => 'WELCOME20']),
                'is_read' => false,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ]);

            // تذكير
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'title' => 'تذكير',
                'message' => 'لا تنسى إكمال بيانات ملفك الشخصي',
                'data' => json_encode(['link' => '/profile']),
                'is_read' => true,
                'read_at' => $safeNow,
                'created_at' => $safeNow,
                'updated_at' => $safeNow,
            ]);
        }
    }
}
