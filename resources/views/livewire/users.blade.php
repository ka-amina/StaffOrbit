<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3">
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            <!-- Modal Form -->
            @if($isOpen)
                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg z-50">
                        <div class="p-4 max-h-[80vh] overflow-y-auto">
                            <h2 class="text-xl font-bold mb-4">{{ $user_id ? 'Edit User' : 'Create User' }}</h2>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" wire:model="name" class="shadow border rounded w-full py-2 px-3">
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="email" wire:model="email" class="shadow border rounded w-full py-2 px-3">
                                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Password:
                                    @if($user_id)
                                        <span class="text-sm text-gray-500">(Leave blank to keep current password)</span>
                                    @endif
                                </label>
                                <input type="password" wire:model="password" class="shadow border rounded w-full py-2 px-3">
                                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- New Avatar Upload Field -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Profile Image:</label>
                                <input type="file" wire:model="temp_avatar" class="shadow border rounded w-full py-2 px-3">
                                <div wire:loading wire:target="temp_avatar">Uploading...</div>
                                @error('temp_avatar') <span class="text-red-500">{{ $message }}</span> @enderror

                                @if ($temp_avatar)
                                    <div class="mt-2">
                                        <p>Image Preview:</p>
                                        <img src="{{ $temp_avatar->temporaryUrl() }}" class="h-24 w-24 object-cover rounded">
                                    </div>
                                @elseif($avatar && !$temp_avatar)
                                    <div class="mt-2">
                                        <p>Current Image:</p>
                                        <img src="{{ Storage::url($avatar) }}" class="h-24 w-24 object-cover rounded">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                                <input type="text" wire:model="phone" class="shadow border rounded w-full py-2 px-3">
                                @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Birth Date:</label>
                                <input type="date" wire:model="birth_date" class="shadow border rounded w-full py-2 px-3">
                                @error('birth_date') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                                <input type="text" wire:model="address" class="shadow border rounded w-full py-2 px-3">
                                @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Recruitment Date:</label>
                                <input type="date" wire:model="recruitment_date" class="shadow border rounded w-full py-2 px-3">
                                @error('recruitment_date') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Salary:</label>
                                <input type="number" wire:model="salary" class="shadow border rounded w-full py-2 px-3">
                                @error('salary') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
                                <select wire:model="departement_id" class="shadow border rounded w-full py-2 px-3">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('departement_id') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Contract Type:</label>
                                <select wire:model="contract_type" class="shadow border rounded w-full py-2 px-3">
                                    <option value="">Select Contract Type</option>
                                    @foreach($contractTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('contract_type') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <select wire:model="status" class="shadow border rounded w-full py-2 px-3">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="terminated">Terminated</option>
                                </select>
                                @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button wire:click="store" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Save User
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
                            <p class="mb-4">Are you sure you want to delete this user? This action cannot be undone.</p>

                            <div class="flex justify-end">
                                <button wire:click="delete({{ $user_id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Delete
                                </button>
                                <button wire:click="closeDeleteModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h2 class="font-semibold text-xl text-gray-800">Manage Users</h2>
                <div class="flex items-center">
                    <input wire:model.live.debounce.300ms="searchTerm" type="text"
                           class="rounded-md mr-2" placeholder="Search users...">
                    <button wire:click="create"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add User
                    </button>
                </div>
            </div>

            <table class="table-auto w-full mt-5">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Profile</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Department</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="border px-4 py-2">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->department_name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($user->status) }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $user->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded">Edit</button>
                            <button wire:click="openDeleteModal({{ $user->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
