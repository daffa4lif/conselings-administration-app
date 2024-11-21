<?php

namespace App\Livewire\ConselingGroup;

use App\Models\Conseling\ConselingGroup;
use Livewire\Component;

class ListConselings extends Component
{
    use \Livewire\WithPagination;
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterOrder = 'new';

    public string $filterStatus = 'All';

    public $perPage = 10;

    public function render()
    {
        $conselings = ConselingGroup::with('students')
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                });
            })
            ->when($this->filterStatus != 'All', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterOrder == 'new', function ($query) {
                $query->orderByDesc('created_at');
            }, function ($query) {
                $query->orderBy('created_at');
            })
            ->paginate($this->perPage);

        return view('livewire.conseling-group.list-conselings', compact("conselings"));
    }
}
