<?php

namespace App\Livewire;

use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Grades extends Component
{
    use WithPagination, AuthorizesRequests;

    public $name;
    public $grade_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
        ];
    }

    public function render()
    {
        $count = Grade::count();
        $searchTerm = '%' . $this->searchTerm . '%';

        return view('livewire.grades', [
            'grades' => Grade::where('name', 'like', $searchTerm)
                ->orderBy('name')
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
        $this->grade_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->grade_id = null;
        $this->resetValidation();
    }

    public function store()
    {
        // Validate directly using the rules method
        $this->validate();

        Grade::updateOrCreate(['id' => $this->grade_id], [
            'name' => $this->name,
        ]);

        session()->flash('message', $this->grade_id ? 'Grade updated successfully.' : 'Grade created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $this->grade_id = $id;
        $this->name = $grade->name;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->grade_id) {
            Grade::find($this->grade_id)->delete();
            session()->flash('message', 'Grade deleted successfully.');
        }
        $this->closeDeleteModal();
    }
}
