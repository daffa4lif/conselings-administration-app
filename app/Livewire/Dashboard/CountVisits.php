<?php

namespace App\Livewire\Dashboard;

use App\Models\HomeVisit;
use Livewire\Component;

class CountVisits extends Component
{
    public function render()
    {
        $total = HomeVisit::count();
        return view('livewire.dashboard.count-visits', compact("total"));
    }
}
