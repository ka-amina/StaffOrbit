<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ContractType;

class Contracts extends Component
{
    use WithPagination;
    // protected $paginationTheme = 'tailwind';

    public $start_date, $end_date, $status, $document_path, $user_id, $contract_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $contractTypes;
    public $contract_type;

    public $searchTerm = '';

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'status' => 'required|in:active,expired,terminated,pending',
        'document_path' => 'nullable|string|max:255',
    ];

    // public function render()
    // {
    //     // Fetch contracts with pagination
    //     // $contracts = Contract::with('user')->paginate(10); // You can change 10 to your desired pagination count
    //     $contracts = Contract::with('user')->paginate(10); // Livewire pagination
    //     return view('livewire.contracts', ['contracts' => $contracts]);
    // }
    public function mount()
{
    $this->contractTypes = ContractType::all(); // Fetch contract types
}



public function render()
{
    $searchTerm = '%' . $this->searchTerm . '%';

    return view('livewire.contracts', [
        'contracts' => Contract::with(['user', 'contractType'])
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->orderBy('start_date', 'desc')
            ->paginate(10),
        'count' => Contract::count(),
        'users' => User::all(),
        'contractTypes' => $this->contractTypes,
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
        $this->contract_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->status = 'active';
        $this->document_path = '';
        // $this->editMode = false;
        $this->resetValidation();
    }



    public function store()
{
    $this->validate();
    $contractType = ContractType::find($this->contract_type); 
    if (!$contractType) {
        session()->flash('error', 'Invalid contract type selected.');
        return;
    }

    DB::transaction(function () use ($contractType) {
        $contract = Contract::updateOrCreate(
            ['id' => $this->contract_id],
            [
                'user_id' => $this->user_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'document_path' => $this->document_path,
            ]
        );

        DB::table('employee_contract')->insert([
            'employee_id' => $this->user_id,
            'contract_id' => $contract->id, // Corrected
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    });

    session()->flash('message', 'Contract created successfully!');
    $this->closeModal();
    $this->resetInputFields();
}


    public function edit($contractId)
    {
        // $this->editMode = true;
        $contract = Contract::findOrFail($contractId);
        $this->contract_id = $contract->id;
        $this->user_id = $contract->user_id;
        $this->start_date = $contract->start_date;
        $this->end_date = $contract->end_date;
        $this->status = $contract->status;
        $this->document_path = $contract->document_path;
        $this->openModal();
    }


    public function delete($contractId)
    {
        $contract = Contract::find($this->contract_id);
        $contract->delete();

        session()->flash('message', 'Contract deleted successfully!');
    }

    public function resetFields()
    {
        $this->user_id = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->status = 'active';
        $this->document_path = '';
        // $this->editMode = false;
    }
}
