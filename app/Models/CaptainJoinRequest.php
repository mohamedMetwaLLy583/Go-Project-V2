<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainJoinRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'city',
        'car_model',
        'status', // e.g. 'pending', 'contacted', 'rejected'
    ];
}
