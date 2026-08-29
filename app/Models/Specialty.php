<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'doctor_id'
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
