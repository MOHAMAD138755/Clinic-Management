<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTimeSlot extends Model
{
    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function casts(): array
    {
        return [
            'doctor_id' => 'integer',
            'date' => 'date',
            'start_time' => 'datetime:H:i:s',
            'end_time' => 'datetime:H:i:s',
            'is_booked' => 'boolean',
        ];
    }
}
