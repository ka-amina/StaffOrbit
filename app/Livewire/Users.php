<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Grade;
use App\Models\Department;
use App\Models\ContractType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $email, $password, $avatar, $phone, $birth_date, $address, $recruitment_date, $contract_type, $departement_id, $salary, $status ,$grade_id;
    public $temp_avatar;
    public $user_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';
    public $departments;
    public $contractTypes;
    public $grades;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user_id)],
            'password' => $this->user_id ? 'nullable|string|min:8' : 'required|string|min:8',
            'temp_avatar' => 'nullable|image|max:1024',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'address' => 'nullable|string',
            'recruitment_date' => 'required|date',
            'contract_type' => 'required|exists:contract_types,id',
            'departement_id' => 'required|exists:departments,id',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,terminated',
            'grade_id' => 'required|exists:grades,id',
        ];
    }

    public function mount()
    {
        $this->departments = Department::all();
        $this->contractTypes = ContractType::all();
        $this->grades = Grade::all();
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        return view('livewire.users', [
            'grades' => $this->grades,
            'users' => User::join('departments', 'users.departement_id', '=', 'departments.id')
                ->select('users.*', 'departments.name as department_name')
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

    public function updateCareerRecord($user, $type, $notes)
    {
        $user->careerRecords()->create([
            'type' => $type,
            'notes' => $notes,
            'status' => 'active',
        ]);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $userData = [
            'grade_id' => $this->grade_id,
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

        if ($this->password) {
            $userData['password'] = bcrypt($this->password);
        }

        if ($this->temp_avatar) {
            if ($this->user_id) {
                $user = User::find($this->user_id);
                if ($user && $user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            $avatarPath = $this->temp_avatar->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update($userData);

            if ($user->wasChanged('salary')) {
                $this->updateCareerRecord($user, 'salary_change', 'Salary updated to ' . $this->salary);
            }
            if ($user->wasChanged('grade_id')) {
                $this->updateCareerRecord($user, 'promotion', 'Grade updated to ' . $this->grade_id);
            }
        } else {
            $user = User::create($userData);
            $user->careerRecords()->create([
                'type' => 'onboarding',
                'notes' => 'User onboarded',
                'status' => 'active',
            ]);
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
        $this->password = '';
        $this->avatar = $user->avatar;
        $this->phone = $user->phone;
        $this->birth_date = $user->birth_date;
        $this->address = $user->address;
        $this->recruitment_date = $user->recruitment_date;
        $this->contract_type = $user->contract_type;
        $this->departement_id = $user->departement_id;
        $this->salary = $user->salary;
        $this->grade_id = $user->grade_id;
        $this->status = $user->status;
        $this->openModal();
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);

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
        $this->grade_id = '';
        $this->status = 'active';
        $this->resetValidation();
    }
}
