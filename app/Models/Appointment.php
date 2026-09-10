<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'id',
        'doctor_id',
        'patient_id',
        'time_slot_id',
        'appointment_date',
        'status',
        'notes',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(DoctorTimeSlot::class,'time_slot_id');
    }
}
