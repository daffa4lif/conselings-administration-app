<?php

namespace App\Livewire\Reports;

use App\Models\Conseling\Conseling;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListConselings extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = [
        'filterStatus' => ['except' => ''],
        'filterYear' => ['except' => '']
    ];

    public string $filterYear;

    public string $filterStatus = 'All';

    public $perPage = 10;

    public function render()
    {
        $years = \Illuminate\Support\Facades\Cache::remember("reports_conselings_years", 60, function () {
            return Conseling::select(
                DB::raw('YEAR(created_at) as year')
            )->groupBy('year')->pluck('year')->toArray();
        });

        rsort($years);

        $conselings = Conseling::with('student')
            ->when($this->filterStatus != 'All', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->whereYear('created_at', $this->filterYear ?? current($years))
            ->paginate($this->perPage);

        return view('livewire.reports.list-conselings', compact("conselings", "years"));
    }
}