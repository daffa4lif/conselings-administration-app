<?php

namespace App\Livewire\Absent;

use App\Models\Absent;
use Livewire\Component;

class ListAbsent extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterType = 'All';

    public string $filterOrder = 'new';

    public $perPage = 10;

    public function render()
    {
        $absents = Absent::with('student')
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('nis', 'like', "%$this->search%")
                        ->orWhere('name', 'like', "%$this->search%");
                });
            })
            ->when($this->filterType != 'All', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterOrder == 'new', function ($query) {
                $query->orderByDesc('violation_date');
            }, function ($query) {
                $query->orderBy('violation_date');
            })
            ->paginate($this->perPage);

        return view('livewire.absent.list-absent', compact("absents"));
    }
}
