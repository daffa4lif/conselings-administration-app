<?php

namespace App\Livewire\Dashboard;

use App\Models\StudenCase;
use Livewire\Component;

class CountCase extends Component
{
    public function render()
    {
        $total = StudenCase::count();

        return view('livewire.dashboard.count-case', compact("total"));
    }
}
