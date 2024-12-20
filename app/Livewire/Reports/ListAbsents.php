<?php

namespace App\Livewire\Reports;

use App\Models\Absent;
use App\Models\Master\Classroom;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListAbsents extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterYear' => ['except' => '']
    ];

    public string $search = '';

    public string $filterYear;

    public string $filterType = 'All';

    public $perPage = 10;

    public function render()
    {
        $years = \Illuminate\Support\Facades\Cache::remember("reports_Absents_Years", 60, function () {
            return Absent::select(
                DB::raw('YEAR(violation_date) as year')
            )->groupBy('year')->pluck('year')->toArray();
        });

        rsort($years);

        $absents = Absent::with('student')
            ->when($this->filterType != 'All', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                });
            })
            ->whereYear('violation_date', $this->filterYear ?? current($years))
            ->paginate($this->perPage);

        return view('livewire.reports.list-absents', compact("absents", "years"));
    }
}
