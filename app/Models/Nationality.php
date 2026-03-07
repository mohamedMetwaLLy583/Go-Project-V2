<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    // علاقة مع المستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scope للبحث
    public function scopeSearch($query, $search)
    {
        return $query->where('name_ar', 'LIKE', "%{$search}%")
                     ->orWhere('name_en', 'LIKE', "%{$search}%");
    }
}