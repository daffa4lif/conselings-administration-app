<?php

namespace App\Livewire\Student;

use App\Models\Conseling\Conseling;
use Livewire\Component;

class ListConseling extends Component
{
    use \Livewire\WithPagination;

    public $id;

    public $perPage = 10;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $conselings = Conseling::where('student_id', $this->id)->paginate($this->perPage, ['*'], 'conseling');

        return view('livewire.student.list-conseling', compact("conselings"));
    }
}
