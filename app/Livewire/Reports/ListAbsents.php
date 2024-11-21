<?php

namespace App\Livewire\Reports;

use App\Models\Master\Classroom;
use App\Models\StudentsClassroom;
use Livewire\Component;

class ListAbsents extends Component
{
    use \Livewire\WithPagination;

    public $perPage = 10;

    public function render()
    {
        $absents = StudentsClassroom::with('classroom')
            ->orderBy('year')
            ->paginate($this->perPage);

        return view('livewire.reports.list-absents');
    }
}
