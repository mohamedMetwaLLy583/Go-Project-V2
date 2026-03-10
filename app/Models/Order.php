<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nationality_id',
        'accept_others_in_car',
        'accept_smoking',
        'car_specification',
        'price',
        'status',
        'notes',
        'is_urgent',
        'distance_km',
        'app_commission',
        'selected_driver_id',
        'cancelled_at',
        'shift_type',
        'trip_type',
        'delivery_days',
        'vacation_days',
        'needs_ac',
        'tinted_glass',
        'car_condition',
        'is_shared',
        'salary',
        'salary_type',
        'start_date',
        'men_count',
        'women_count',
        'student_m_count',
        'student_f_count',
    ];

    protected $casts = [
        'accept_others_in_car' => 'boolean',
        'accept_smoking' => 'boolean',
        'is_urgent' => 'boolean',
        'price' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function selectedDriver()
    {
        return $this->belongsTo(User::class, 'selected_driver_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function passengers()
    {
        return $this->hasMany(OrderPassenger::class);
    }

    public function driverRequests()
    {
        return $this->hasMany(DriverOrderRequest::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(
            User::class,
            'driver_order_requests',
            'order_id',
            'driver_id'
        )->withPivot(['proposed_price', 'status', 'notes'])
            ->withTimestamps();
    }
}
