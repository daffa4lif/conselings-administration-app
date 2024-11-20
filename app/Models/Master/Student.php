<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function classroom(): HasMany
    {
        return $this->hasMany(\App\Models\StudentsClassroom::class, 'student_id');
    }

    public function absent(): HasMany
    {
        return $this->hasMany(\App\Models\Absent::class, 'student_id');
    }
}
