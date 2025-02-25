<div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Departments</h2>
                        <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full shadow-sm">
                            {{ $count }} Departments
                        </span>
                    </div>
                    <div class="flex items-center">
                        <input wire:model.live.debounce.300ms="searchTerm" type="text" class="rounded-md mr-2" placeholder="Search departments...">
                        @if($canManageDepartments)
                        <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Department
                        </button>
                        @endif
                    </div>
                </div>

                <table class="table-auto w-full mt-5">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">ID</th>
                            <th class="px-4 py-2">Name</th>
                            @if($canManageDepartments)
                            <th class="px-4 py-2">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                        <tr>
                            <td class="border px-4 py-2">{{ $department->id }}</td>
                            <td class="border px-4 py-2">{{ $department->name }}</td>
                            @if($canManageDepartments)
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $department->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Edit
                                </button>
                                <button wire:click="openDeleteModal({{ $department->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                    Delete
                                </button>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td class="border px-4 py-2 text-center" colspan="{{ $canManageDepartments ? '3' : '2' }}">No departments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $departments->links() }}
                </div>

                <!-- Create/Edit Modal -->
                @if($isOpen)
                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg z-50">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-4">{{ $department_id ? 'Edit Department' : 'Create Department' }}</h2>

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" id="name" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button wire:click="store" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Save
                                </button>
                                <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Delete Confirmation Modal -->
                @if($isDeleteModalOpen)
                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg z-50">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
                            <p class="mb-4">Are you sure you want to delete this department?</p>
                            <div class="flex justify-end">
                                <button wire:click="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Yes, Delete
                                </button>
                                <button wire:click="closeDeleteModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>