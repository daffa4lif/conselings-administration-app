<?php

namespace App\Livewire\Classroom;

use App\Models\StudentsClassroom;
use Livewire\Component;

class ListStudents extends Component
{
    use \Livewire\WithPagination;

    public $id;

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterKelamin = 'All';

    public $filterYears = 'All';

    public $perPage = 10;

    public $years = [];

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $students = StudentsClassroom::with('student')->where('classroom_id', $this->id)
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                });
            })
            ->when($this->filterKelamin != 'All', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('gender', $this->filterKelamin);
                });
            })
            ->when($this->filterYears != 'All', function ($query) {
                $query->where('year', $this->filterYears);
            })
            ->paginate($this->perPage);

        $data = \Illuminate\Support\Facades\Cache::remember("students_classroom_years_$this->id", 60, function () {
            return StudentsClassroom::where('classroom_id', $this->id)->pluck('year')->unique()->toArray();
        });

        sort($data);

        $this->years = $data;

        return view('livewire.classroom.list-students', [
            "students" => $students,
            "years" => $this->years
        ]);
    }
}
