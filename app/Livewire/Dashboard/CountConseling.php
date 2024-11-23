<?php

namespace App\Livewire\Dashboard;

use App\Models\Conseling\Conseling;
use Livewire\Component;

class CountConseling extends Component
{
    public function render()
    {
        $total = Conseling::count();

        return view('livewire.dashboard.count-conseling', compact("total"));
    }
}
