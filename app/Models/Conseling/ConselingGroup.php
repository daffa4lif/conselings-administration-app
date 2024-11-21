<?php

namespace App\Models\Conseling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class ConselingGroup extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Master\Student::class, "conseling_student", "student_id", "conseling_group_id")
            ->using(ConselingStudents::class);
    }
}
