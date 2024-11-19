<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueClassroomName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $major = request()->input('major');

        if (\App\Models\Master\Classroom::where(['name' => $value, 'major' => $major])->exists()) {
            $fail('kelas dengan jurusan yang sama telah ada.');
        }
    }
}
