<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Department;
use App\Models\Formation;
use App\Models\Post;

use Livewire\Component;

class Dashboard extends Component
{
    public $totalUsers;
    public $totalDepartments;
    public $totalFormations;
    public $totalPosts;
    public $recentPosts;
    public $usersByDepartment;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalDepartments = Department::count();
        $this->totalFormations = Formation::count();
        $this->totalPosts = Post::count();
        
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
