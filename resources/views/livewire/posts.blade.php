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
                            <h2 class="text-xl font-bold mb-4">{{ $post_id ? 'Edit Post' : 'Create Post' }}</h2>

                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                                <input type="text" wire:model="title" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                <textarea wire:model="description" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
                                <select wire:model="department_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button wire:click="store" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Save Post
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
                    <h2 class="font-semibold text-xl text-gray-800">Manage Posts</h2>
                    <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                        {{ $count }} Posts
                    </span>
                </div>
                <div class="flex items-center">
                    <input wire:model.live.debounce.300ms="searchTerm" type="text" class="rounded-md mr-2" placeholder="Search posts...">
                    <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Post
                    </button>
                </div>
            </div>

            <table class="table-auto w-full mt-5">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Department</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td class="border px-4 py-2">{{ $post->title }}</td>
                            <td class="border px-4 py-2">{{ $post->department->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $post->id }})" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded">Edit</button>
                                <button wire:click="openDeleteModal({{ $post->id }})" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
