<?php

namespace App\Livewire\Reports;

use App\Models\HomeVisit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListVisits extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = ['filterYear' => ['except' => '']];

    public string $filterYear;

    public $perPage = 10;

    public function render()
    {
        $years = \Illuminate\Support\Facades\Cache::remember("reports_Home_Visis_Years", 60, function () {
            return HomeVisit::select(
                DB::raw('YEAR(created_at) as year')
            )->groupBy('year')->pluck('year')->toArray();
        });

        rsort($years);

        $visits = HomeVisit::with('student')
            ->whereYear('created_at', $this->filterYear ?? current($years))
            ->paginate($this->perPage);

        return view('livewire.reports.list-visits', compact("years", "visits"));
    }
}