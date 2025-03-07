<?php

namespace App\Livewire;

use App\Models\Conge;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class AllCongeList extends Component
{
    use WithPagination;
    
    public $status = null;
    public $year = null;
    public $user_id = null;
    
    protected $listeners = ['congeRequested' => '$refresh'];
    
    public function mount()
    {
        if (!Auth::user()->can('manage-leave')) {
            abort(403, 'Unauthorized action.');
        }
        $this->year = now()->year;
        $this->check();
    }
    
    public function updatedStatus()
    {
        $this->resetPage();
    }
    
    public function updatedYear()
    {
        $this->resetPage();
    }
    
    public function updatedUserId()
    {
        $this->resetPage();
    }
    
    public function check()
    {
        $conges = Conge::where('status', 'pending')->get();
        
        foreach ($conges as $conge) {
            $hrApproved = $conge->hr_approval ?? null;
            $managerApproved = $conge->manager_approval ?? null;
            
            if ($hrApproved === 0 || $managerApproved === 0) {
                $conge->update(['status' => 'rejected']);
            } elseif ($hrApproved === 1 && $managerApproved === 1) {
                $conge->update(['status' => 'approved']);
                $user = User::findOrFail($conge->user_id);
                $user->solde_conge = $user->solde_conge - $conge->total_days;
                $user->save();
            }
        }
    }
    
    public function cancelRequestRh($congeId)
    {
        $conge = Conge::findOrFail($congeId);
        
        if ($conge->status === 'pending') {
            $conge->hr_approval = false;
            $conge->save();
            $this->check();
            
            session()->flash('success', 'Demande de congé rejetée par RH.');
        } else {
            session()->flash('error', 'Impossible de rejeter cette demande de congé.');
        }
    }
    
    public function cancelRequestManager($congeId)
    {
        $conge = Conge::findOrFail($congeId);
        
        if ($conge->status === 'pending') {
            $conge->manager_approval = false;
            $conge->save();
            $this->check();
            
            session()->flash('success', 'Demande de congé rejetée par le manager.');
        } else {
            session()->flash('error', 'Impossible de rejeter cette demande de congé.');
        }
    }
    
    public function approveRequestRh($congeId) {
        $conge = Conge::findOrFail($congeId);
        if ($conge->status === 'pending') {
            $conge->hr_approval = true;
            $conge->save();
            $this->check();
            
            session()->flash('success', 'Demande de congé approuvée par RH.');
        } else {
            session()->flash('error', 'Impossible d\'approuver cette demande de congé.');
        }
    }
    
    public function approveRequestManager($congeId) {
        $conge = Conge::findOrFail($congeId);
        if ($conge->status === 'pending') {
            $conge->manager_approval = true;
            $conge->save();
            $this->check();
            session()->flash('success', 'Demande de congé approuvée par le manager.');
        } else {
            session()->flash('error', 'Impossible d\'approuver cette demande de congé.');
        }
    }
    
    public function render()
    {
        $query = Conge::query();
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->year) {
            $query->whereYear('start_date', $this->year);
        }
        
        if ($this->user_id) {
            $query->where('user_id', $this->user_id);
        }
        
        $conges = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $years = Conge::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        $users = User::all();
        
        return view('livewire.conge', [
            'conges' => $conges,
            'years' => $years,
            'users' => $users
        ]);
    }
}