<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebRideRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'pickup_location',
        'dropoff_location',
        'status', // pending, completed, cancelled
    ];
}
