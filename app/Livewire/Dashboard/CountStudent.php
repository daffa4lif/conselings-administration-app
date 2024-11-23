<?php

namespace App\Livewire\Dashboard;

use App\Models\Master\Student;
use Livewire\Component;

class CountStudent extends Component
{
    public function render()
    {
        $total = Student::count();

        return view('livewire.dashboard.count-student', compact("total"));
    }
}
