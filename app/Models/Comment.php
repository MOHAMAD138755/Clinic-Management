<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'parent_id',
        'comment_body',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
