<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DriverAvailability;
use App\Models\CarImage;
use Illuminate\Support\Facades\File;
use Twilio\Rest\Client;
use App\Models\Otp;
use Twilio\Exceptions\TwilioException;

class AuthController extends Controller
{
    /**
     * Register a regular user with profile picture.
     */
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20|unique:users,phone',
            'age' => 'required|integer|min:18',
            'nationality_id' => 'required|exists:nationalities,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'age' => $request->age,
                'nationality_id' => $request->nationality_id,
                'type' => 3, // User
                'coins' => 0,
                'status' => 1,
            ];

            $user = User::create($userData);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $profilePicture = $this->uploadProfilePicture($request->file('profile_picture'), $user->id);
                $user->profile_picture = $profilePicture;
                $user->save();
            }

            DB::commit();

            $token = auth('api')->login($user);

            return $this->respondWithToken($token, $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Register a driver with availability, profile picture, and car images.
     */
    public function registerDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20|unique:users,phone',
            'age' => 'required|integer|min:18',
            'nationality_id' => 'required|exists:nationalities,id',

            // Profile picture
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Driver availability
            'availability' => 'required|array|min:1',
            'availability.*.neighborhood_id' => 'required|exists:neighborhoods,id',
            'availability.*.day_id' => 'required|exists:days,id',
            'availability.*.start_time' => 'required|date_format:H:i:s',
            'availability.*.end_time' => 'required|date_format:H:i:s|after:availability.*.start_time',

            // Driver preferences
            'accept_smoking' => 'required|boolean',
            'accept_others' => 'required|boolean',
            'car_type' => 'required|in:regular,separated',

            // Car images - adjusted to 3 images as per design
            'car_images' => 'required|array|min:3|max:10',
            'car_images.*' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            // Create User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'age' => $request->age,
                'nationality_id' => $request->nationality_id,
                'type' => 2, // Driver
                'accept_smoking' => $request->accept_smoking,
                'accept_others' => $request->accept_others,
                'car_type' => $request->car_type,
                'coins' => 0,
                'wallet_balance' => 0,
                'status' => 1,
            ];

            $user = User::create($userData);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $profilePicture = $this->uploadProfilePicture($request->file('profile_picture'), $user->id);
                $user->profile_picture = $profilePicture;
                $user->save();
            }

            // Create Availability
            $availabilityData = [];
            foreach ($request->availability as $slot) {
                $availability = DriverAvailability::create([
                    'driver_id' => $user->id,
                    'neighborhood_id' => $slot['neighborhood_id'],
                    'day_id' => $slot['day_id'],
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'is_active' => true,
                ]);

                // Load relationships for response
                $availability->load(['neighborhood', 'day']);
                $availabilityData[] = $availability;
            }

            // Upload Car Images
            if ($request->hasFile('car_images')) {
                foreach ($request->file('car_images') as $index => $image) {
                    $imagePath = $this->uploadCarImage($image, $user->id, $index + 1);

                    CarImage::create([
                        'user_id' => $user->id,
                        'image_path' => $imagePath
                    ]);
                }
            }

            DB::commit();

            $token = auth('api')->login($user);

            // Get complete user data with relationships
            $user->load(['driverAvailability.neighborhood', 'driverAvailability.day', 'carImages']);

            return $this->respondWithToken($token, $user, $availabilityData);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Upload profile picture to public directory
     */
    private function uploadProfilePicture($file, $userId)
    {
        // Create directory if it doesn't exist
        $uploadPath = public_path('upload/users/' . $userId . '/profile');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'profile_' . time() . '.' . $extension;

        // Move file to public directory
        $file->move($uploadPath, $filename);

        // Return relative path for database
        return 'upload/users/' . $userId . '/profile/' . $filename;
    }

    /**
     * Upload car image to public directory
     */
    private function uploadCarImage($file, $userId, $index)
    {
        // Create directory if it doesn't exist
        $uploadPath = public_path('upload/users/' . $userId . '/car');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'car_' . $index . '_' . time() . '.' . $extension;

        // Move file to public directory
        $file->move($uploadPath, $filename);

        // Return relative path for database
        return 'upload/users/' . $userId . '/car/' . $filename;
    }

    /**
     * Get the authenticated User with all related data.
     */
    public function me()
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
     * Get the token array structure with user data.
     */
    protected function respondWithToken($token, $user = null, $availability = null)
    {
        // If user is not provided, get it from the token
        if (!$user) {
            try {
                $user = auth('api')->user();
            } catch (\Exception $e) {
                $user = null;
            }
        }

        // Prepare response base
        $response = [
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];

        // Add user data if available
        if ($user) {
            // Add full URL for profile picture
            if ($user->profile_picture) {
                $user->profile_picture_url = url($user->profile_picture);
            }

            // Load car images for driver
            if ($user->type == 2) {
                $user->load('carImages');
                foreach ($user->carImages as $carImage) {
                    $carImage->image_url = url($carImage->image_path);
                }
            }

            $response['user'] = $user;

            // Add availability data separately if provided
            if ($availability) {
                $response['availability'] = $availability;
            } elseif ($user->type == 2 && $user->driverAvailability) {
                $response['availability'] = $user->driverAvailability;
            }
        }

        return response()->json($response);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();
        return $this->respondWithToken($token, $user);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        try {
            // Get the new token
            $newToken = auth('api')->refresh();

            // Get the user from the new token
            $user = auth('api')->setToken($newToken)->user();

            // Return response with new token and user data
            return $this->respondWithToken($newToken, $user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    public function sendOtp(Request $request)
    {
        $phone = $request->phone;
        $code = rand(100000, 999999);

        DB::beginTransaction();

        try {

            $client = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $client->messages->create($phone, [
                'from' => config('services.twilio.from'),
                'body' => "Your OTP is: $code"
            ]);

            Otp::updateOrCreate(
                ['phone' => $phone],
                [
                    'code' => $code,
                    'expires_at' => now()->addMinutes(5)
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully'
            ]);
        } catch (TwilioException $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال الرسالة',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ غير متوقع'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $otp = Otp::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP غير صحيح أو منتهي'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم التحقق بنجاح'
        ]);
    }
}
