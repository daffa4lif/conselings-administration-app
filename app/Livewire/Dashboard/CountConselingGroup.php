<?php

namespace App\Livewire\Dashboard;

use App\Models\Conseling\ConselingGroup;
use Livewire\Component;

class CountConselingGroup extends Component
{
    public function render()
    {
        $total = ConselingGroup::count();
        return view('livewire.dashboard.count-conseling-group', compact("total"));
    }
}
