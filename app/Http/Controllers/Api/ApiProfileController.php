<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DriverAvailability;
use App\Models\CarImage;

class ApiProfileController extends Controller
{
    /**
     * Get the authenticated User with all related data.
     */
    public function index()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Load relationships based on user type
        if ($user->type == 2) { // Driver
            $user->load([
                'driverAvailability.neighborhood.city',
                'driverAvailability.day',
                'carImages'
            ]);

            // Add full URLs for images
            if ($user->profile_picture) {
                $user->profile_picture_url = url($user->profile_picture);
            }

            foreach ($user->carImages as $carImage) {
                $carImage->image_url = url($carImage->image_path);
            }
        } else {
            // Add full URL for profile picture
            if ($user->profile_picture) {
                $user->profile_picture_url = url($user->profile_picture);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Get user coins.
     */
    public function getCoins()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'coins' => $user->coins
        ]);
    }

    /**
     * delete account and all related data (for testing purposes)
     * 
     */
    public function deleteAccount(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            DB::beginTransaction();

            // Delete related data based on user type
            if ($user->type == 2) { // Driver
                DriverAvailability::where('driver_id', $user->id)->delete();
                CarImage::where('user_id', $user->id)->delete();
            }

            // Delete user
            $user->delete();

            DB::commit();

            return response()->json(['message' => 'Account and related data deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete account: ' . $e->getMessage()], 500);
        }
    }

    /**
     * update account and all related data (for testing purposes)
     * 
     */
    /**
     * Update user account (works for both regular users and drivers)
     */
    public function updateAccount(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            DB::beginTransaction();

            // قواعد التحقق الأساسية المشتركة
            $rules = [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'sometimes|string|max:20|unique:users,phone,' . $user->id,
                'age' => 'sometimes|integer|min:18',
                'nationality_id' => 'sometimes|exists:nationalities,id',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            // إضافة قواعد التحقق الخاصة بالسائق إذا كان المستخدم من نوع driver
            if ($user->type == 2) { // Driver
                $driverRules = [
                    // تحديث availability (اختياري)
                    'availability' => 'sometimes|array|min:1',
                    'availability.*.neighborhood_id' => 'required_with:availability|exists:neighborhoods,id',
                    'availability.*.day_id' => 'required_with:availability|exists:days,id',
                    'availability.*.start_time' => 'required_with:availability|date_format:H:i:s',
                    'availability.*.end_time' => 'required_with:availability|date_format:H:i:s|after:availability.*.start_time',

                    // تحديث صور السيارة (اختياري)
                    'car_images' => 'sometimes|array|min:1|max:10',
                    'car_images.*' => 'required_with:car_images|image|mimes:jpeg,png,jpg|max:5120',

                    // تحديث التفضيلات (اختياري)
                    'accept_smoking' => 'sometimes|boolean',
                    'accept_others' => 'sometimes|boolean',
                    'car_type' => 'sometimes|in:regular,separated',

                    // حذف صور محددة (اختياري)
                    'delete_car_images' => 'sometimes|array',
                    'delete_car_images.*' => 'exists:car_images,id',
                ];

                $rules = array_merge($rules, $driverRules);
            }

            // التحقق من صحة البيانات
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // تحديث البيانات الأساسية
            $userData = [];

            if ($request->has('name')) {
                $userData['name'] = $request->name;
            }

            if ($request->has('email')) {
                $userData['email'] = $request->email;
            }

            if ($request->has('password')) {
                $request->validate(['password' => 'sometimes|string|min:6|confirmed']);
                $userData['password'] = bcrypt($request->password);
            }

            if ($request->has('phone')) {
                $userData['phone'] = $request->phone;
            }

            if ($request->has('age')) {
                $userData['age'] = $request->age;
            }

            if ($request->has('nationality_id')) {
                $userData['nationality_id'] = $request->nationality_id;
            }

            if ($request->has('accept_smoking')) {
                $userData['accept_smoking'] = $request->accept_smoking;
            }

            if ($request->has('accept_others')) {
                $userData['accept_others'] = $request->accept_others;
            }

            if ($request->has('car_type')) {
                $userData['car_type'] = $request->car_type;
            }

            // تحديث صورة الملف الشخصي
            if ($request->hasFile('profile_picture')) {
                // حذف الصورة القديمة إذا وجدت
                if ($user->profile_picture) {
                    $this->deleteOldProfilePicture($user->profile_picture);
                }

                $profilePicture = $this->uploadProfilePicture($request->file('profile_picture'), $user->id);
                $userData['profile_picture'] = $profilePicture;
            }

            // تطبيق التحديثات على المستخدم
            if (!empty($userData)) {
                $user->update($userData);
            }

            // معالجة بيانات السائق إذا كان المستخدم من نوع driver
            if ($user->type == 2) { // Driver

                // تحديث availability
                if ($request->has('availability')) {
                    // حذف availability القديم 
                    DriverAvailability::where('driver_id', $user->id)->delete();

                    foreach ($request->availability as $slot) {
                        // يمكنك إما إنشاء جديد أو تحديث الموجود
                        DriverAvailability::updateOrCreate(
                            [
                                'driver_id' => $user->id,
                                'neighborhood_id' => $slot['neighborhood_id'],
                                'day_id' => $slot['day_id'],
                            ],
                            [
                                'start_time' => $slot['start_time'],
                                'end_time' => $slot['end_time'],
                                'is_active' => $slot['is_active'] ?? true,
                            ]
                        );
                    }
                }

                // إضافة صور جديدة للسيارة
                if ($request->hasFile('car_images')) {
                    $currentImagesCount = CarImage::where('user_id', $user->id)->count();

                    foreach ($request->file('car_images') as $index => $image) {
                        // التحقق من عدم تجاوز الحد الأقصى (10 صور)
                        if ($currentImagesCount + ($index + 1) <= 10) {
                            $imagePath = $this->uploadCarImage($image, $user->id, $currentImagesCount + $index + 1);

                            CarImage::create([
                                'user_id' => $user->id,
                                'image_path' => $imagePath
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            // تحميل العلاقات حسب نوع المستخدم
            if ($user->type == 2) { // Driver
                $user->load(['driverAvailability.neighborhood', 'driverAvailability.day', 'carImages']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to delete old profile picture
     */
    private function deleteOldProfilePicture($profilePicturePath)
    {
        if ($profilePicturePath && file_exists(public_path($profilePicturePath))) {
            unlink(public_path($profilePicturePath));
        }
    }
}
