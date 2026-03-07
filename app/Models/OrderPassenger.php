<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPassenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'type',
        'pickup_location',
        'return_location',
        'pickup_time',
        'return_time',
        'pickup_lat',
        'pickup_lng',
        'return_lat',
        'return_lng',
        'pickup_neighborhood',
        'return_neighborhood',
        'pickup_location_type',
        'return_location_type',
        'driver_arrival_time',
        'work_start_time',
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'return_time' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
