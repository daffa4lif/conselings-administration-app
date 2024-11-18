<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentsClassroom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Student::class, 'student_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Classroom::class, 'classroom_id');
    }
}
