<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Departments;
use App\Livewire\Contracts;
use App\Livewire\Posts;
use App\Livewire\Dashboard;
use App\Livewire\Formations;
use App\Livewire\Grades;
use App\Livewire\Users;
use App\Livewire\Career;
use App\Livewire\Conge\CongeForm;
use App\Livewire\Conge\CongeList;
use App\Livewire\AllCongeList;

// use App\Models\Contract;

Route::view('/', 'welcome');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/departments', Departments::class)->name('departments');

Route::get('/posts', Posts::class)->name('posts');
Route::get('/formations', Formations::class)->name('formations');
Route::get('/grades', Grades::class)->name('grades');
Route::get('/users', Users::class)->name('users');
Route::get('/users/{userId}', Career::class)->name('career');
Route::get('/demande/{userId}', CongeForm::class)->name('demande');
Route::get('/listConge', CongeList::class)->name('conge');
Route::get('/allConge', AllCongeList::class)->name('listconge');
Route::get('/contracts', Contracts::class)->middleware(['auth'])->name('contracts.index');
// Route::get('/departments', function () {
//     return view('departments');
// })->name('departments');

// Route::middleware(['auth', 'check.permission:view departments'])->group(function () {
//     Route::get('/departments', function () {
//         return view('departments');
//     })->name('departments');
// });

require __DIR__ . '/auth.php';
