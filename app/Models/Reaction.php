<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'type',
    ];

    public function casts(): array
    {
        return [
            'type' => 'boolean',
        ];
    }
}
