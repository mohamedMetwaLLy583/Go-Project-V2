<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * عرض كل الإشعارات للمستخدم الحالي
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $query = Notification::forUser($user->id)->recent();

            // فلترة حسب حالة القراءة
            if ($request->has('filter')) {
                if ($request->filter == 'unread') {
                    $query->unread();
                } elseif ($request->filter == 'read') {
                    $query->read();
                }
            }

            // عدد الإشعارات غير المقروءة
            $unreadCount = Notification::forUser($user->id)->unread()->count();

            $notifications = $query->get()->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'is_read' => $notification->is_read,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at,
                    'formatted_created_at' => $notification->formatted_created_at,
                    'read_at' => $notification->read_at,
                ];
            });

            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
                'total_count' => $notifications->count(),
                'data' => $notifications
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في جلب الإشعارات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض إشعار محدد
     */
    public function show($id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $notification = Notification::forUser($user->id)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'error' => 'الإشعار غير موجود'
                ], 404);
            }

            // تحديد إذا كان الإشعار مقروء أم لا
            $isNew = !$notification->is_read;

            return response()->json([
                'success' => true,
                'is_new' => $isNew,
                'data' => [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'is_read' => $notification->is_read,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at,
                    'formatted_created_at' => $notification->formatted_created_at,
                    'read_at' => $notification->read_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في جلب الإشعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث حالة الإشعار (قراءة/غير مقروء)
     */
    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'is_read' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $notification = Notification::forUser($user->id)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'error' => 'الإشعار غير موجود'
                ], 404);
            }

            if ($request->is_read) {
                $notification->markAsRead();
            } else {
                $notification->markAsUnread();
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الإشعار بنجاح',
                'data' => [
                    'id' => $notification->id,
                    'is_read' => $notification->is_read,
                    'read_at' => $notification->read_at
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في تحديث الإشعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث كل الإشعارات كمقروءة
     */
    public function markAllAsRead()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $count = Notification::forUser($user->id)
                ->unread()
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => "تم تحديث {$count} إشعار كمقروء",
                'marked_count' => $count
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في تحديث الإشعارات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف إشعار
     */
    public function destroy($id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $notification = Notification::forUser($user->id)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'error' => 'الإشعار غير موجود'
                ], 404);
            }

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الإشعار بنجاح'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في حذف الإشعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف كل الإشعارات
     */
    public function destroyAll()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $count = Notification::forUser($user->id)->count();
            
            Notification::forUser($user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => "تم حذف {$count} إشعار بنجاح",
                'deleted_count' => $count
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في حذف الإشعارات: ' . $e->getMessage()
            ], 500);
        }
    }

}