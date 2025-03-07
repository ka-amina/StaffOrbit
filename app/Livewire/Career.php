<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use App\Models\ContractType;
use App\Models\CareerRecord;
use App\Models\Grade;
use App\Models\Formation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Career extends Component
{
    public $user;
    public $userId;
    public $departmentName;
    public $contractTypeName;
    public $manager;
    public $userGrade;
    public $careerRecords;
    public $contracts;

    public $isEditModalOpen = false;
    public $lastCareerRecord;
    public $editCareerRecord = [
        'type' => '',
        'notes' => '',
        'end_date' => '',
        'status' => '',
        'salary' => '',
        'formation_id' => '',
        'contract_id' => '',
        'grade_id' => ''
    ];

    public $grades;
    public $formations;
    public $contractTypes;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->userProfile();
        $this->loadDropdownOptions();
    }

    protected function userProfile()
    {
        $this->user = User::findOrFail($this->userId);
        $this->departmentName = Department::find($this->user->departement_id)->name ?? 'Not Assigned';
        $this->contractTypeName = ContractType::find($this->user->contract_type)->name ?? 'Not Assigned';
        $this->manager = User::find($this->user->manager_id ?? 0)?->name ?? 'Not Assigned';

        $this->careerRecords = $this->user->careerRecords()->orderBy('created_at', 'asc')->get();
        $this->contracts = $this->user->contracts()->orderBy('start_date', 'asc')->get();

        $this->lastCareerRecord = $this->careerRecords->last();

        $latestGrade = $this->careerRecords->where('grade_id', '!=', null)->last();
        $this->userGrade = $latestGrade ? Grade::find($latestGrade->grade_id)->name : null;
    }

    protected function loadDropdownOptions()
    {
        $this->grades = Grade::all();
        $this->formations = Formation::all();
        $this->contractTypes = ContractType::all();
    }

    public function openEditModal()
    {
        $this->isEditModalOpen = true;

        if ($this->lastCareerRecord) {
            $this->editCareerRecord = [
                'type' => $this->lastCareerRecord->type ?? '',
                'notes' => $this->lastCareerRecord->notes ?? '',
                'end_date' => $this->lastCareerRecord->end_date ? $this->lastCareerRecord->end_date : null,
                'status' => $this->lastCareerRecord->status ?? '',
                'salary' => $this->lastCareerRecord->salary ?? '',
                'formation_id' => $this->lastCareerRecord->formation_id ?? null,
                'contract_id' => $this->lastCareerRecord->contract_id ?? null,
                'grade_id' => $this->lastCareerRecord->grade_id ?? null
            ];
        } else {
            $this->editCareerRecord = [
                'type' => '',
                'notes' => '',
                'end_date' => '',
                'status' => '',
                'salary' => '',
                'formation_id' => '',
                'contract_id' => '',
                'grade_id' => ''
            ];
        }

        $this->dispatch('open-modal');
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->resetValidation();
    }

    public function updateCareerRecord()
    {
        $validatedData = $this->validate([
            'editCareerRecord.type' => 'required|in:promotion,salary_change,training,onboarding',
            'editCareerRecord.notes' => 'nullable|string',
            'editCareerRecord.end_date' => 'nullable|date',
            'editCareerRecord.status' => 'required|in:active,inactive,pending',
            'editCareerRecord.salary' => 'nullable|numeric',
            'editCareerRecord.formation_id' => 'nullable|exists:formations,id',
            'editCareerRecord.contract_id' => 'nullable|exists:contracts,id',
            'editCareerRecord.grade_id' => 'nullable|exists:grades,id'
        ]);

        $isChanged = false;
        if ($this->lastCareerRecord) {
            if (
                $this->editCareerRecord['type'] != $this->lastCareerRecord->type ||
                $this->editCareerRecord['notes'] != $this->lastCareerRecord->notes ||
                $this->editCareerRecord['end_date'] != $this->lastCareerRecord->end_date ||
                $this->editCareerRecord['status'] != $this->lastCareerRecord->status ||
                $this->editCareerRecord['salary'] != $this->lastCareerRecord->salary ||
                $this->editCareerRecord['formation_id'] != $this->lastCareerRecord->formation_id ||
                $this->editCareerRecord['contract_id'] != $this->lastCareerRecord->contract_id ||
                $this->editCareerRecord['grade_id'] != $this->lastCareerRecord->grade_id
            ) {
                $isChanged = true;
            }
        } else {
            // If there's no previous record, consider any non-empty values as changes
            if (
                !empty($this->editCareerRecord['type']) ||
                !empty($this->editCareerRecord['notes']) ||
                !empty($this->editCareerRecord['end_date']) ||
                !empty($this->editCareerRecord['status']) ||
                !empty($this->editCareerRecord['salary']) ||
                !empty($this->editCareerRecord['formation_id']) ||
                !empty($this->editCareerRecord['contract_id']) ||
                !empty($this->editCareerRecord['grade_id'])
            ) {
                $isChanged = true;
            }
        }
        if (!$isChanged) {
            $this->closeEditModal();
            return;
        }

        DB::beginTransaction();

        try {
            $careerRecord = new CareerRecord();
            $careerRecord->user_id = $this->userId;
            $careerRecord->type = $this->editCareerRecord['type'];
            $careerRecord->notes = $this->editCareerRecord['notes'];
            // $careerRecord->salary = $this->editCareerRecord['salary'];
            $careerRecord->end_date = $this->editCareerRecord['end_date'];
            $careerRecord->status = $this->editCareerRecord['status'];
            $careerRecord->formation_id = $this->editCareerRecord['formation_id'];
            $careerRecord->contract_id = $this->editCareerRecord['contract_id'];
            $careerRecord->grade_id = $this->editCareerRecord['grade_id'];



            $user = User::findOrFail($this->userId);
            $user->salary = $this->editCareerRecord['salary'];
            $user->contract_type = $this->editCareerRecord['contract_id'];
            $user->grade_id=$this->editCareerRecord['grade_id'];
            $user->save();




            $careerRecord->save();

            DB::commit();

            $this->userProfile();
            $this->closeEditModal();

            session()->flash('message', 'New career record created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create career record. Please try again.');
        }
    }
    public function render()
    {
        return view('livewire.career');
    }
}
