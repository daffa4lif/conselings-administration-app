<?php

namespace App\Livewire\Conseling;

use App\Models\Conseling\Conseling;
use Livewire\Component;

class ListConseling extends Component
{
    use \Livewire\WithPagination;
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterOrder = 'new';

    public string $filterStatus = 'All';

    public string $filterCategori = 'All';

    public $perPage = 10;

    public function render()
    {
        $categories = [
            Conseling::CATEGORY_AKADEMIK,
            Conseling::CATEGORY_NON_AKADEMIK,
            Conseling::CATEGORY_KEDISIPLINAN
        ];

        $conselings = Conseling::with('student')
            ->when($this->search != '', function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%$this->search%")
                        ->orWhere('nis', 'like', "%$this->search%");
                });
            })
            ->when($this->filterStatus != 'All', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterCategori != 'All', function ($query) {
                $query->where('category', $this->filterCategori);
            })
            ->when($this->filterOrder == 'new', function ($query) {
                $query->orderByDesc('created_at');
            }, function ($query) {
                $query->orderBy('created_at');
            })
            ->paginate($this->perPage);

        return view('livewire.conseling.list-conseling', compact("conselings", "categories"));
    }
}
