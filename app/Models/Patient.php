<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'full_name',
        'national_code',
        'address',
        'phone',
        'birth_date',
        'created_at',
        'updated_at',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
