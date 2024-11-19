<?php

namespace App\Livewire\Student;

use App\Models\Master\Student;
use Livewire\Component;

class ListStudents extends Component
{
    use \Livewire\WithPagination;
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterKelamin = 'All';

    public $perPage = 10;

    public function render()
    {
        $students = Student::when($this->search != '', function ($query) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('nis', 'like', "%$this->search%");
        })
            ->when($this->filterKelamin != 'All', function ($query) {
                $query->where('gender', $this->filterKelamin);
            })
            ->paginate($this->perPage);

        return view('livewire.student.list-students', compact('students'));
    }
}
