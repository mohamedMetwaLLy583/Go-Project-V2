<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAvailability extends Model
{
    use HasFactory;

    protected $table = 'driver_availability';

    protected $fillable = [
        'driver_id',
        'neighborhood_id',
        'day_id',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function city()
    {
        return $this->throughNeighborhood()->hasCity();
    }

    public function country()
    {
        return $this->throughNeighborhood()->hasCountry();
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfDay($query, $dayId)
    {
        return $query->where('day_id', $dayId);
    }

    public function scopeOfNeighborhood($query, $neighborhoodId)
    {
        return $query->where('neighborhood_id', $neighborhoodId);
    }

    public function scopeAvailableNow($query)
    {
        $now = now();
        $currentDay = $now->dayOfWeek + 1; // Laravel: 0=Sunday, Our system: 1=Sunday

        return $query->where('day_id', $currentDay)
            ->where('start_time', '<=', $now->format('H:i:s'))
            ->where('end_time', '>=', $now->format('H:i:s'))
            ->active();
    }

    // Accessor للوقت بشكل منسق
    public function getTimeRangeAttribute(): string
    {
        return $this->start_time->format('h:i A') . ' - ' . $this->end_time->format('h:i A');
    }

    // Accessor للوقت بشكل 24 ساعة
    public function getTimeRange24hAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    // ميثود للتحقق إذا الوقت متاح الآن
    public function isAvailableNow(): bool
    {
        $now = now();
        $currentDay = $now->dayOfWeek + 1;

        return $this->day_id == $currentDay &&
            $this->start_time->format('H:i:s') <= $now->format('H:i:s') &&
            $this->end_time->format('H:i:s') >= $now->format('H:i:s') &&
            $this->is_active;
    }

    
}
