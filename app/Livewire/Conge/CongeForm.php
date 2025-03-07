<?php

namespace App\Livewire\Conge;

use App\Models\Conge;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CongeForm extends Component
{
    public $type = 'Congé annuel';
    public $start_date;
    public $end_date;
    public $total_days = 0;
    public $reason;
    
    protected $rules = [
        'type' => 'required|string',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    public function mount()
    {
        $this->start_date = Carbon::now()->addDays(7)->format('Y-m-d');
        $this->end_date = Carbon::now()->addDays(8)->format('Y-m-d');
        $this->calculateDays();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        if ($propertyName === 'start_date' || $propertyName === 'end_date') {
            $this->calculateDays();
        }
    }

    public function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $this->total_days = $start->diffInWeekdays($end) + 1;
        }
    }

    public function submit()
    {
        $this->validate();
        
        $user = Auth::user();
        
        if ($this->type === 'Congé annuel' && $user->solde_conge - $user->leave_days < $this->total_days) {
            session()->flash('error', 'Solde de congé insuffisant. Vous avez ' . $user->solde_conge . ' jours disponibles.');
            return;
        }

        if ($this->type === 'Congé annuel') {
            $oneWeekFromNow = Carbon::now()->addDays(7);
            $requestStart = Carbon::parse($this->start_date);
            
            if ($requestStart->lessThan($oneWeekFromNow)) {
                session()->flash('error', 'Les demandes de congé annuel doivent être soumises au moins une semaine à l\'avance.');
                return;
            }
        }
        
        Conge::create([
            'user_id' => $user->id,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Demande de congé soumise avec succès.');
        $this->reset(['type', 'reason']);
        $this->mount();
        $this->dispatch('congeRequested');
    }

    public function render()
    {
        return view('livewire.conge.conge-form', [
            'leaveBalance' => Auth::user()->solde_conge
        ]);
    }
}