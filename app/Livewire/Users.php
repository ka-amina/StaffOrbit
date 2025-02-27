<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // Add this for file uploads
use App\Models\User;
use App\Models\Department;
use App\Models\ContractType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads; // Add this trait

    public $name, $email, $password, $avatar, $phone, $birth_date, $address, $recruitment_date, $contract_type, $departement_id, $salary, $status;
    public $temp_avatar; // For temporary file upload
    public $user_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';
    public $departments;
    public $contractTypes;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user_id)],
            'password' => $this->user_id ? 'nullable|string|min:8' : 'required|string|min:8',
            'temp_avatar' => 'nullable|image|max:1024', // 1MB Max
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'address' => 'nullable|string',
            'recruitment_date' => 'required|date',
            'contract_type' => 'required|exists:contract_types,id',
            'departement_id' => 'required|exists:departments,id',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,terminated',
        ];
    }

    public function mount()
    {
        $this->departments = Department::all();
        $this->contractTypes = ContractType::all();
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        return view('livewire.users', [
            'users' => User::join('departments', 'users.departement_id', '=', 'departments.id')
                ->select('users.*', 'departments.name as department_name') // Fetch department name
                ->where('users.name', 'like', $searchTerm)
                ->orWhere('users.email', 'like', $searchTerm)
                ->orderBy('users.name')
                ->paginate(10),
            'count' => User::count(),
            'departments' => $this->departments,
            'contractTypes' => $this->contractTypes,
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openDeleteModal($id)
    {
        $this->user_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    public function store()
    {
        $validatedData = $this->validate();

        // Create data array with base fields
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'recruitment_date' => $this->recruitment_date,
            'contract_type' => $this->contract_type,
            'departement_id' => $this->departement_id,
            'salary' => $this->salary,
            'status' => $this->status,
        ];

        // Handle password conditionally
        if ($this->password) {
            $userData['password'] = bcrypt($this->password);
        }

        // Handle avatar upload if present
        if ($this->temp_avatar) {
            // Delete old image if it exists and we're updating
            if ($this->user_id) {
                $user = User::find($this->user_id);
                if ($user && $user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            // Store the new image
            $avatarPath = $this->temp_avatar->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        // Update or create the user
        if ($this->user_id) {
            // If updating, only update filled fields
            $user = User::find($this->user_id);
            $user->update($userData);
        } else {
            // If creating new user, include all fields
            User::create($userData);
        }

        session()->flash('message', 'User saved successfully!');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Don't fill password for security
        $this->avatar = $user->avatar;
        $this->phone = $user->phone;
        $this->birth_date = $user->birth_date;
        $this->address = $user->address;
        $this->recruitment_date = $user->recruitment_date;
        $this->contract_type = $user->contract_type;
        $this->departement_id = $user->departement_id;
        $this->salary = $user->salary;
        $this->status = $user->status;
        $this->openModal();
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);

        // Delete user avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $this->closeDeleteModal();
        session()->flash('message', 'User deleted successfully!');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetFields()
    {
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->avatar = '';
        $this->temp_avatar = null;
        $this->phone = '';
        $this->birth_date = '';
        $this->address = '';
        $this->recruitment_date = '';
        $this->contract_type = '';
        $this->departement_id = '';
        $this->salary = '';
        $this->status = 'active';
        $this->resetValidation();
    }
}
