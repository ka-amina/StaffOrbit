<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
            <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3">
                <p class="text-sm">{{ session('message') }}</p>
            </div>
            @endif
            <!-- Form Section -->
            @if($isOpen)
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg z-50">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-4">{{ $contract_id ? 'Edit Contract' : 'Create Contract' }}</h2>

                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">User:</label>
                            <select wire:model="user_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select User</option>
                                @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                            <input type="date" wire:model="start_date" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                            <input type="date" wire:model="end_date" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <select wire:model="contract_type">
                            <option value="">Select Contract Type</option>
                            @foreach($contractTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                            <select wire:model="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                                <option value="terminated">Terminated</option>
                                <option value="pending">Pending</option>
                            </select>
                            @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="document_path" class="block text-gray-700 text-sm font-bold mb-2">Document Path:</label>
                            <input type="text" wire:model="document_path" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('document_path') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end pt-2">
                            <button wire:click="store" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Save Contract
                            </button>
                            <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <h2 class="font-semibold text-xl text-gray-800">Manage Contracts</h2>
                    <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                        {{ $count }} Contracts
                    </span>
                </div>
                <div class="flex items-center">
                    <input wire:model.live.debounce.300ms="searchTerm" type="text" class="rounded-md mr-2" placeholder="Search contracts...">
                    <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Contract
                    </button>
                </div>
            </div>

            <table class="table-auto w-full mt-5">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Contract ID</th>
                        <th class="px-4 py-2">Start Date</th>
                        <th class="px-4 py-2">End Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $contract)
                    <tr>
                        <td class="border px-4 py-2">{{ $contract->user->name }}</td>
                        <td class="border px-4 py-2">{{ $contract->id }}</td>
                        <td class="border px-4 py-2">{{ $contract->start_date }}</td>
                        <td class="border px-4 py-2">{{ $contract->end_date ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($contract->status) }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $contract->id }})" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded">Edit</button>
                            <button wire:click="openDeleteModal({{ $contract->id }})" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="mt-4">
                {{ $contracts->links() }}
            </div>
        </div>
    </div>
</div>