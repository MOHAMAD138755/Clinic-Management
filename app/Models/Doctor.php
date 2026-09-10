<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'medical_system_number',
        'phone',
        'profile',
        'active',
        'biography',
        'specialty_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorTimeSlots()
    {
        return $this->hasMany(DoctorTimeSlot::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function scopeSearch($query, $search = null)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhereHas('specialties', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
        });
    }

}
