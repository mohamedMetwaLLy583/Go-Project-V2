<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderWithPassengersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'nationality_id' => $this->nationality_id,
            'nationality_name' => $this->nationality->name_ar,
            'price' => (float) $this->price,
            'status' => $this->status,
            'notes' => $this->notes,
            'is_urgent' => (bool) $this->is_urgent,
            'distance_km' => $this->distance_km,
            'app_commission' => $this->app_commission,
            // تفضيلات الرحلة
            'accept_others_in_car' => (bool) $this->accept_others_in_car,
            'accept_smoking' => (bool) $this->accept_smoking,
            'car_specification' => $this->car_specification,
            'shift_type' => $this->shift_type,
            'trip_type' => $this->trip_type,
            'delivery_days' => is_string($this->delivery_days) ? json_decode($this->delivery_days) : $this->delivery_days,
            'vacation_days' => is_string($this->vacation_days) ? json_decode($this->vacation_days) : $this->vacation_days,
            'needs_ac' => (bool) $this->needs_ac,
            'tinted_glass' => (bool) $this->tinted_glass,
            'car_condition' => $this->car_condition,
            'is_shared' => (bool) $this->is_shared,
            'salary' => (float) $this->salary,
            'salary_type' => $this->salary_type,
            'start_date' => $this->start_date ? \Carbon\Carbon::parse($this->start_date)->format('Y-m-d') : null,
            'men_count' => (int) $this->men_count,
            'women_count' => (int) $this->women_count,
            'student_m_count' => (int) $this->student_m_count,
            'student_f_count' => (int) $this->student_f_count,
            'passengers_count' => $this->passengers->count(),

            // الركاب
            'passengers' => $this->passengers->map(function ($passenger) {
                return [
                    'id' => $passenger->id,
                    'name' => $passenger->name,
                    'type' => $passenger->type,
                    'pickup_location' => $passenger->pickup_location,
                    'return_location' => $passenger->return_location,
                    'pickup_time' => $passenger->pickup_time ? $passenger->pickup_time->format('Y-m-d H:i:s') : null,
                    'return_time' => $passenger->return_time ? $passenger->return_time->format('Y-m-d H:i:s') : null,
                    'pickup_lat' => $passenger->pickup_lat,
                    'pickup_lng' => $passenger->pickup_lng,
                    'return_lat' => $passenger->return_lat,
                    'return_lng' => $passenger->return_lng,
                    'pickup_neighborhood' => $passenger->pickup_neighborhood,
                    'return_neighborhood' => $passenger->return_neighborhood,
                    'pickup_location_type' => $passenger->pickup_location_type,
                    'return_location_type' => $passenger->return_location_type,
                    'driver_arrival_time' => $passenger->driver_arrival_time,
                    'work_start_time' => $passenger->work_start_time,
                ];
            }),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
