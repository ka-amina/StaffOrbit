<?php

namespace App\Livewire\Conge;

use App\Models\Conge;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CongeList extends Component
{
    use WithPagination;

    public $status = null;
    public $year = null;

    protected $listeners = ['congeRequested' => '$refresh'];

    public function mount()
    {
        $this->year = now()->year;
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }


    public function render()
    {
        $query = Conge::where('user_id', Auth::id());

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->year) {
            $query->whereYear('start_date', $this->year);
        }

        $conges = $query->orderBy('created_at', 'desc')->paginate(10);
        Conge::selectRaw('YEAR(start_date) as year')
            ->where('user_id', Auth::id())
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('livewire.conge.conge-list', [
            'conges' => $conges,
        ]);
    }
}
