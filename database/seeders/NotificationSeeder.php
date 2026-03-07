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
        // جلب المستخدمين
        $users = User::all();

        foreach ($users as $user) {
            // إشعارات عامة
            Notification::create([
                'user_id' => $user->id,
                'title' => 'مرحباً بك في التطبيق',
                'message' => 'شكراً لانضمامك إلينا. نتمنى لك تجربة ممتعة!',
                'data' => ['action' => 'welcome'],
                'is_read' => false,
            ]);

            // عرض خاص
            Notification::create([
                'user_id' => $user->id,
                'title' => 'عرض خاص 🎉',
                'message' => 'احصل على خصم 20% على أول باقة تشترك فيها',
                'data' => ['discount' => 20, 'code' => 'WELCOME20'],
                'is_read' => false,
            ]);

            // تذكير
            Notification::create([
                'user_id' => $user->id,
                'title' => 'تذكير',
                'message' => 'لا تنسى إكمال بيانات ملفك الشخصي',
                'data' => ['link' => '/profile'],
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}
