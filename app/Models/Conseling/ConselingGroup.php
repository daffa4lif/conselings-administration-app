<?php

namespace App\Models\Conseling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConselingGroup extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Student::class, "student_id");
    }
}
