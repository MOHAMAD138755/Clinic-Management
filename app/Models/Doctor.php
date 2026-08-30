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
        'active',
        'biography',
        'specialty_id'
    ];

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
}
