<?php

namespace App\Livewire\Classroom;

use App\Models\Master\Classroom;
use Livewire\Component;

class ListClassroom extends Component
{
    use \Livewire\WithPagination;
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterMajor = 'All';

    public $perPage = 10;

    public function render()
    {
        $classrooms = Classroom::when($this->search != '', function ($query) {
            $query->where('name', 'like', "%$this->search%");
        })
            ->when($this->filterMajor != 'All', function ($query) {
                $query->where('major', $this->filterMajor);
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.classroom.list-classroom', compact("classrooms"));
    }
}
