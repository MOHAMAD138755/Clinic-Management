<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'parent_id',
        'comment_body',
        'status',
        'created_at',
        'updated_at',
    ];
}
