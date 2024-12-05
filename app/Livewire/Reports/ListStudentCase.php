<?php

namespace App\Livewire\Reports;

use App\Models\StudenCase;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListStudentCase extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterYear' => ['except' => '']
    ];

    public string $search = '';

    public string $filterYear;

    public string $filterStatus = 'All';

    public string $filterType = 'All';

    public $perPage = 10;

    public function render()
    {
        $years = \Illuminate\Support\Facades\Cache::remember("reports_cases_years", 60, function () {
            return StudenCase::select(
                DB::raw('YEAR(created_at) as year')
            )->groupBy('year')->pluck('year')->toArray();
        });

        rsort($years);

        $cases = StudenCase::with('student')
            ->when($this->filterType != 'All', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterStatus != 'All', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                });
            })
            ->whereYear('created_at', $this->filterYear ?? current($years))
            ->paginate($this->perPage);

        return view('livewire.reports.list-student-case', compact("years", "cases"));
    }
}
