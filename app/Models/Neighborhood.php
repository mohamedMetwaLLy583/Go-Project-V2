<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'region_id',
        'name_ar',
        'name_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // علاقة مع المدينة
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // علاقة مع الدولة من خلال المدينة
    public function country()
    {
        return $this->throughCity()->hasCountry();
    }

    // علاقة مع توفر السائقين
    public function driverAvailabilities()
    {
        return $this->hasMany(DriverAvailability::class);
    }

    // Scope للأحياء النشطة
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope للبحث
    public function scopeSearch($query, $search)
    {
        return $query->where('name_ar', 'LIKE', "%{$search}%")
                     ->orWhere('name_en', 'LIKE', "%{$search}%");
    }

    // Scope لأحياء مدينة معينة
    public function scopeOfCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }
}