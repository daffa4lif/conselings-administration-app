<?php

namespace App\Livewire\Student;

use App\Models\Absent;
use App\Models\HomeVisit;
use App\Models\StudentsClassroom;
use Livewire\Component;

class ListClassroom extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function placeholder()
    {
        return view('livewire.skeleton.table');
    }

    public function render()
    {
        $studentClass = StudentsClassroom::with('classroom')
            ->where('student_id', $this->id)
            ->orderByDesc('year')
            ->get()
            ->each(function ($item) {
                $item->absentTotal = Absent::where('student_id', $this->id)
                    ->whereYear('violation_date', $item->year)->count();

                $item->homeVisitTotal = HomeVisit::where('student_id', $this->id)
                    ->whereYear('created_at', $item->year)->count();
            });

        return view('livewire.student.list-classroom', compact("studentClass"));
    }
}
