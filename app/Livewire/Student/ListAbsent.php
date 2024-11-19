<?php

namespace App\Livewire\Student;

use App\Models\Absent;
use App\Models\StudentsClassroom;
use Livewire\Component;

class ListAbsent extends Component
{
    use \Livewire\WithPagination;

    public $id;

    public $perPage = 10;

    public $filterType = 'All';
    public $filterYear = 'All';

    protected $queryString = [
        'filterType' => ['except' => ''],
        'filterYear' => ['except' => '']
    ];

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
        $absents = Absent::where('student_id', $this->id)
            ->when($this->filterType != 'All', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterYear != 'All', function ($query) {
                $query->whereYear('violation_date', $this->filterYear);
            })
            ->orderByDesc('violation_date')
            ->paginate($this->perPage);

        $years = array_keys(StudentsClassroom::where('student_id', $this->id)->get()->groupBy('year')->toArray());

        return view('livewire.student.list-absent', compact("absents", "years"));
    }
}
