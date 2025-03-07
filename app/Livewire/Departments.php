<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
// use Illuminate\Support\Facades\Validator;
// use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Departments extends Component
{
    use WithPagination, AuthorizesRequests;

    // protected $paginationTheme = 'tailwind';
    
    public $name;
    public $department_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:departments,name,' . $this->department_id,
        ];
    }

    public function mount()
    {
        if (!Auth::user()->can('manage departments')) {
            abort(403, 'Unauthorized action.');
        }
    }
    public function render()
    {
        $count=Department::count();
        $searchTerm = '%' . $this->searchTerm . '%';
        
        return view('livewire.departments', [
            'departments' => Department::where('name', 'like', $searchTerm)
                ->orderBy('name')
                ->paginate(10),
                'canManageDepartments' => Auth::user()->can('manage departments'),
            'count'=>$count
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
        $this->department_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->department_id = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Department::updateOrCreate(['id' => $this->department_id], [
            'name' => $this->name,
        ]);

        session()->flash('message', $this->department_id ? 'Department updated successfully.' : 'Department created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $this->department_id = $id;
        $this->name = $department->name;
        
        $this->openModal();
    }

    public function delete()
    {
        if ($this->department_id) {
            Department::find($this->department_id)->delete();
            session()->flash('message', 'Department deleted successfully.');
        }
        $this->closeDeleteModal();
    }
}