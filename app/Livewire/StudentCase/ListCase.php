<?php

namespace App\Livewire\StudentCase;

use App\Models\StudenCase;
use Livewire\Component;

class ListCase extends Component
{
    use \Livewire\WithPagination;

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterStatus = 'All';

    public string $filterType = 'All';

    public string $filterOrder = 'old';

    public $perPage = 10;

    public function render()
    {
        $cases = StudenCase::with('student')
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                })->orWhere('parent_name', 'like', "%$this->search%");
            })
            ->when($this->filterStatus != 'All', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterType != 'All', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterOrder == 'old', function ($query) {
                $query->orderBy('created_at');
            }, function ($query) {
                $query->orderByDesc('created_at');
            })
            ->paginate($this->perPage);

        return view('livewire.student-case.list-case', compact('cases'));
    }
}
