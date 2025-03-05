<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- User Profile Header -->
            <div class="flex justify-between items-start mb-6">
                <a href="{{ route('users') }}" class="text-blue-500 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Users
                </a>

            </div>

            <!-- User Info Card -->
            <div class="flex flex-col items-center">
                <!-- Profile image - centered -->
                <div class="mb-6 flex flex-col items-center">
                    @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" class="w-32 h-32 rounded-full object-cover border-4 border-blue-100" alt="{{ $user->name }}">
                    @else
                    <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center text-3xl text-blue-500 font-bold border-4 border-blue-100">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    @endif
                    <h2 class="text-2xl font-bold mt-4">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <p class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800' :
                           ($user->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($user->status) }}
                    </p>
                </div>

                <!-- Progress Container -->
                <div class="relative flex items-center justify-between w-3/4 mx-auto">
                    <!-- Blue Progress Line -->
                    <div class="absolute top-3 left-0 right-0 mx-auto w-[90%] h-1 bg-blue-500 z-0"></div>

                    @if ($careerRecords->isEmpty())
                    <!-- Default Steps -->
                    <div class="relative flex w-full justify-between">
                        <div class="relative text-center">
                            <div class="h-6 w-6 rounded-full bg-blue-500 border-2 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium">Onboarding</div>
                            <div class="text-xs text-gray-500">{{ date('M Y', strtotime($user->recruitment_date)) }}</div>
                        </div>

                        <div class="relative text-center">
                            <div class="h-6 w-6 rounded-full bg-blue-500 border-2 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium">Contract</div>
                            <div class="text-xs text-gray-500">{{ $contractTypeName }}</div>
                        </div>

                        <div class="relative text-center">
                            <div class="h-6 w-6 rounded-full bg-blue-500 border-4 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium">Current Position</div>
                            <div class="text-xs text-gray-500">{{ $departmentName }}</div>
                        </div>

                        <div class="relative text-center">
                            <div class="h-6 w-6 rounded-full bg-gray-300 border-2 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium text-gray-400">Next Step</div>
                            <div class="text-xs text-gray-400">Promotion</div>
                        </div>
                    </div>
                    @else
                    <!-- Dynamic Steps -->
                    <div class="relative flex w-full justify-between">
                        @foreach ($careerRecords as $index => $record)
                        <div class="relative flex flex-col items-center">
                            <div class="h-6 w-6 rounded-full bg-blue-500 border-2 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium">{{ ucfirst($record->type) }}</div>
                            <div class="text-xs text-gray-500">{{ $record->end_date }}</div>
                        </div>
                        @endforeach

                        

                        <div class="relative text-center">
                            <div class="h-6 w-6 rounded-full bg-gray-300 border-2 border-white shadow z-10"></div>
                            <div class="mt-2 text-sm font-medium text-gray-400">Next Step</div>
                            <div class="text-xs text-gray-400">Promotion</div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            <!-- Contract Details Card -->
            <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Contract</h3>
                    <div class="ml-auto">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Type: {{ $contractTypeName }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Siège / Ville</div>
                            <div class="font-medium">{{ $user->address ?? 'Not specified' }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Date</div>
                            <div class="font-medium">{{ date('d M Y', strtotime($user->recruitment_date)) }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Département</div>
                            <div class="font-medium">{{ $departmentName }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Manager</div>
                            <div class="font-medium">{{ $manager }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Salary</div>
                            <div class="font-medium">{{ $user->salary }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Grade</div>
                            <div class="font-medium">{{ $userGrade ?? '' }}</div>
                        </div>
                    </div>


                </div>
                <div class="flex space-x-1 justify-end">
                    <div class="">
                        <button
                            wire:click="openEditModal"
                            class="p-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            @if($isEditModalOpen)
            <div
                x-data="{ open: @entangle('isEditModalOpen') }"
                x-show="open"
                class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Overlay -->
                    <div
                        x-show="open"
                        class="fixed inset-0 transition-opacity"
                        aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal Content -->
                    <div
                        x-show="open"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form wire:submit.prevent="updateCareerRecord">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Edit Career Record
                                </h3>

                                <!-- Type Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Record Type
                                    </label>
                                    <select
                                        wire:model="editCareerRecord.type"
                                        class="w-full px-3 py-2 border rounded-md">
                                        <option value="">Select Type</option>
                                        <option value="promotion">Promotion</option>
                                        <option value="salary_change">Salary Change</option>
                                        <option value="training">Training</option>
                                        <option value="onboarding">Onboarding</option>
                                    </select>
                                    @error('editCareerRecord.type')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Status
                                    </label>
                                    <select
                                        wire:model="editCareerRecord.status"
                                        class="w-full px-3 py-2 border rounded-md">
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                    @error('editCareerRecord.status')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Salary Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Salary
                                    </label>
                                    <input
                                        type="number"
                                        wire:model="editCareerRecord.salary"
                                        class="w-full px-3 py-2 border rounded-md"
                                        placeholder="Enter Salary">
                                    @error('editCareerRecord.salary')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- End Date Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        End Date
                                    </label>
                                    <input
                                        type="date"
                                        wire:model="editCareerRecord.end_date"
                                        class="w-full px-3 py-2 border rounded-md">
                                    @error('editCareerRecord.end_date')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Notes Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Notes
                                    </label>
                                    <textarea
                                        wire:model="editCareerRecord.notes"
                                        class="w-full px-3 py-2 border rounded-md"
                                        placeholder="Enter any additional notes"></textarea>
                                    @error('editCareerRecord.notes')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Dropdowns for Formation, Contract, Grade -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Formation
                                    </label>
                                    <select
                                        wire:model="editCareerRecord.formation_id"
                                        class="w-full px-3 py-2 border rounded-md">
                                        <option value="">Select Formation</option>
                                        @foreach($formations as $formation)
                                        <option value="{{ $formation->id }}">{{ $formation->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Contract
                                    </label>
                                    <select
                                        wire:model="editCareerRecord.contract_id"
                                        class="w-full px-3 py-2 border rounded-md">
                                        <option value="">Select Contract</option>
                                        @foreach($contractTypes as $contract)
                                        <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Grade
                                    </label>
                                    <select
                                        wire:model="editCareerRecord.grade_id"
                                        class="w-full px-3 py-2 border rounded-md">
                                        <option value="">Select Grade</option>
                                        @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button
                                    type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Save Changes
                                </button>
                                <button
                                    type="button"
                                    wire:click="closeEditModal"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>