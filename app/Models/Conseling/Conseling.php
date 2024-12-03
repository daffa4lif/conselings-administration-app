<?php

namespace App\Models\Conseling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conseling extends Model
{
    use HasFactory;

    const CATEGORY_AKADEMIK = "AKADEMIK";
    const CATEGORY_NON_AKADEMIK = "NON-AKADEMIK";
    const CATEGORY_KEDISIPLINAN = "KEDISIPLINAN";

    protected $guarded = [
        'id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Student::class, "student_id");
    }
}
