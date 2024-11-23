<?php

namespace App\Models;

use App\Models\Master\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudenCase extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, "student_id");
    }
}
