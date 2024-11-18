<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function student()
    {
        return $this->hasMany(\App\Models\StudentsClassroom::class, 'student_id');
    }
}
