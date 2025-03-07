<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Posts extends Component
{
    use WithPagination;

    public $title, $description, $department_id, $post_id;
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $searchTerm = '';
    public $departmentOptions;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'department_id' => 'nullable|exists:departments,id',
    ];

    public function mount()
    {
        if (!Auth::user()->can('manage-jobs')) {
            abort(403, 'Unauthorized action.');
        }
        $this->departmentOptions = Department::all();
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        return view('livewire.posts', [
            'posts' => Post::with('department')
                ->where('title', 'like', $searchTerm)
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'departments' => $this->departmentOptions,
            'count' => Post::count(),
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
        $this->post_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->department_id = '';
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Post::updateOrCreate(
            ['id' => $this->post_id],
            [
                'title' => $this->title,
                'description' => $this->description,
                'department_id' => $this->department_id,
            ]
        );

        session()->flash('message', 'Post saved successfully!');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($postId)
    {
        $post = Post::findOrFail($postId);
        $this->post_id = $post->id;
        $this->title = $post->title;
        $this->description = $post->description;
        $this->department_id = $post->department_id;
        $this->openModal();
    }

    public function delete($postId)
    {
        $post = Post::findOrFail($this->post_id);
        $post->delete();

        session()->flash('message', 'Post deleted successfully!');
    }
}
