<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    const SAT = 0;
    const SUN = 1;
    const MON = 2;
    const TUE = 3;
    const WED = 4;
    const THU = 5;
    const FRI = 6;

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
        $raw = $this->getRawOriginal('day_of_week');
        return $week[$raw] ?? '';
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
