<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // أنواع المستخدمين
    const TYPE_ADMIN = 1;
    const TYPE_DRIVER = 2;
    const TYPE_USER = 3;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'nationality_id',
        'profile_picture',
        'type',
        'password',
        'fcm_token',
        'wallet_balance',
        'accept_smoking',
        'accept_others',
        'car_type',
        'average_rating',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'type' => 'integer',
    ];

    // Required methods for JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        if ($this->type === self::TYPE_ADMIN && !$this->role_id) {
            return true; // Super Admin if type is 1 and no specific role
        }
        
        if (!$this->role) {
            return false;
        }

        return in_array($permission, $this->role->permissions ?? []);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function driverAvailability()
    {
        return $this->hasMany(DriverAvailability::class, 'driver_id');
    }
    public function neighborhoods()
    {
        return $this->hasManyThrough(
            Neighborhood::class,
            DriverAvailability::class,
            'driver_id',
            'id',
            'id',
            'neighborhood_id'
        );
    }

    public function scopeDrivers($query)
    {
        return $query->where('type', self::TYPE_DRIVER);
    }

    public function scopeAdmins($query)
    {
        return $query->where('type', self::TYPE_ADMIN);
    }

    public function scopeRegularUsers($query)
    {
        return $query->where('type', self::TYPE_USER);
    }

    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public function isDriver(): bool
    {
        return $this->type === self::TYPE_DRIVER;
    }

    public function isRegularUser(): bool
    {
        return $this->type === self::TYPE_USER;
    }

    public function getTypeTextAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_ADMIN => 'مدير',
            self::TYPE_DRIVER => 'سائق',
            self::TYPE_USER => 'مستخدم',
            default => 'غير محدد',
        };
    }

    protected $appends = ['profile_picture_url'];


    // Accessors
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return url($this->profile_picture);
        }
        return null;
    }

    public function carImages()
    {
        return $this->hasMany(CarImage::class);
    }
}
