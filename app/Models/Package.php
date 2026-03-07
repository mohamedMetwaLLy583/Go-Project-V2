<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'coins',
        'duration',
        'duration_unit',
        'features',
        'status',
        'sort_order',
        'is_popular',
        'investment_amount',
        'target_audience',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'investment_amount' => 'integer',
        'target_audience' => 'string',
    ];

    /**
     * الباقات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * ترتيب الباقات
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
