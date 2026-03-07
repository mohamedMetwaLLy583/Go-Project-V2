<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'status'
    ];

    /**
     * السلايدرات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * الحصول على رابط الصورة كامل
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url($this->image) : null;
    }
}
