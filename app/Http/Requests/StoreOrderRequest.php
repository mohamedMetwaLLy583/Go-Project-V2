<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'nationality_id' => 'required|exists:nationalities,id',
            'price' => 'nullable|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'salary_type' => 'nullable|in:weekly,monthly',
            'distance_km' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string', // Some users might not add notes even if asterisk is there, but if required: 'required|string'
            'is_urgent' => 'required|boolean',
            
            // New UI Sync Fields
            'shift_type' => 'required|in:fixed,variable',
            'trip_type' => 'required|in:round_trip,go_only,return_only',
            'delivery_days' => 'required|array',
            'vacation_days' => 'nullable|array',
            'needs_ac' => 'nullable|boolean',
            'tinted_glass' => 'nullable|boolean',
            'car_condition' => 'nullable|in:standard,new',
            'is_shared' => 'nullable|boolean',
            'start_date' => 'required|date',
            'men_count' => 'nullable|integer|min:0',
            'women_count' => 'nullable|integer|min:0',
            'student_m_count' => 'nullable|integer|min:0',
            'student_f_count' => 'nullable|integer|min:0',

            // Passengers
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.type' => 'nullable|in:male,female,child,elderly',
            'passengers.*.pickup_lat' => 'nullable|string',
            'passengers.*.pickup_lng' => 'nullable|string',
            'passengers.*.return_lat' => 'nullable|string',
            'passengers.*.return_lng' => 'nullable|string',
            
            'passengers.*.pickup_location' => 'required|string',
            'passengers.*.pickup_location_type' => 'required|in:home,work,school',
            'passengers.*.pickup_neighborhood' => 'required|string',
            
            'passengers.*.return_location' => 'required|string',
            'passengers.*.return_location_type' => 'required|in:home,work,school',
            'passengers.*.return_neighborhood' => 'required|string',
            
            'passengers.*.driver_arrival_time' => 'required|string',
            'passengers.*.work_start_time' => 'required|string',
            'passengers.*.pickup_time' => 'nullable|string',
            'passengers.*.return_time' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nationality_id.required' => 'الجنسية مطلوبة',
            'passengers.required' => 'يجب إضافة راكب واحد على الأقل',
            'passengers.*.name.required' => 'اسم الراكب مطلوب',
            'passengers.*.pickup_location.required' => 'موقع الانطلاق مطلوب',
        ];
    }
}