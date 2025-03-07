<?php

namespace App\Livewire;

use App\Models\Formation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Formations extends Component
{
    use WithPagination, AuthorizesRequests;

    public $nom;
    public $type;
    public $date_formation;
    public $formation_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';

    protected $listeners = ['refreshComponent' => '$refresh'];


    public function mount()
    {
        if (!Auth::user()->can('manage-formation')) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected function rules()
    {
        return [
            'nom' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'date_formation' => 'required|date',
        ];
    }

    public function render()
    {
        $count = Formation::count();
        $searchTerm = '%' . $this->searchTerm . '%';

        return view('livewire.formations', [
            'formations' => Formation::where('nom', 'like', $searchTerm)
                ->orderBy('nom')
                ->paginate(10),
            'count' => $count
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openDeleteModal($id)
    {
        $this->formation_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->nom = '';
        $this->type = '';
        $this->date_formation = '';
        $this->formation_id = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Formation::updateOrCreate(['id' => $this->formation_id], [
            'nom' => $this->nom,
            'type' => $this->type,
            'date_formation' => $this->date_formation,
        ]);

        session()->flash('message', $this->formation_id ? 'Formation updated successfully.' : 'Formation created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $formation = Formation::findOrFail($id);
        $this->formation_id = $id;
        $this->nom = $formation->nom;
        $this->type = $formation->type;
        $this->date_formation = $formation->date_formation;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->formation_id) {
            Formation::find($this->formation_id)->delete();
            session()->flash('message', 'Formation deleted successfully.');
        }
        $this->closeDeleteModal();
    }
}
