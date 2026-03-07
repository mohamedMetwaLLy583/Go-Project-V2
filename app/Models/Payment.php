<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'purchase_id',
        'purchase_token',
        'title',
        'coins',
        'price',
        'status',
        'date',
        'package_id',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    public function isCanceled()
    {
        return $this->status === 'canceled';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
