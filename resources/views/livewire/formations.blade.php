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
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Formations</h2>
                        <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full shadow-sm">
                            {{ $count }} Formations
                        </span>
                    </div>
                    <div class="flex items-center">
                        <input wire:model.live.debounce.300ms="searchTerm" type="text" class="rounded-md mr-2" placeholder="Search formations...">

                            <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Formation
                            </button>

                    </div>
                </div>

                <table class="table-auto w-full mt-5">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">ID</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Date de Formation</th>

                            <th class="px-4 py-2">Actions</th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse($formations as $formation)
                        <tr>
                            <td class="border px-4 py-2">{{ $formation->id }}</td>
                            <td class="border px-4 py-2">{{ $formation->nom }}</td>
                            <td class="border px-4 py-2">{{ $formation->type }}</td>
                            <td class="border px-4 py-2">{{ $formation->date_formation }}</td>

                                <td class="border px-4 py-2">
                                    <button wire:click="edit({{ $formation->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                        Edit
                                    </button>
                                    <button wire:click="openDeleteModal({{ $formation->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                        Delete
                                    </button>
                                </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="border px-4 py-2 text-center">No formations found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $formations->links() }}
                </div>

                <!-- Create/Edit Modal -->
                @if($isOpen)
                    <div class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="absolute inset-0 bg-black opacity-50"></div>
                        <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg z-50">
                            <div class="p-4">
                                <h2 class="text-xl font-bold mb-4">{{ $formation_id ? 'Edit Formation' : 'Create Formation' }}</h2>

                                <div class="mb-4">
                                    <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                                    <input type="text" id="nom" wire:model="nom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('nom') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                                    <input type="text" id="type" wire:model="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('type') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="date_formation" class="block text-gray-700 text-sm font-bold mb-2">Date de Formation:</label>
                                    <input type="date" id="date_formation" wire:model="date_formation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('date_formation') <span class="text-red-500">{{ $message }}</span> @enderror
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
                                <p class="mb-4">Are you sure you want to delete this formation?</p>
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
