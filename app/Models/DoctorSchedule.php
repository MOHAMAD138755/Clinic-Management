<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    const SUN = 0;
    const MON = 1;
    const TUE = 2;
    const WED = 3;
    const THU = 4;
    const FRI = 5;
    const SAT = 6;

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'duration',
        'is_active',
    ];

    public function casts(): array
    {
        return [
            'day_of_week' => 'integer',
        ];
    }

    public function getDayOfWeekAttribute(): string
    {
        $week = [
            self::SAT => 'saturday',
            self::SUN => 'sunday',
            self::MON => 'monday',
            self::TUE => 'tuesday',
            self::WED => 'wednesday',
            self::THU => 'thursday',
            self::FRI => 'friday',
        ];
        return $week[$this->day_of_week] ?? '';
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
