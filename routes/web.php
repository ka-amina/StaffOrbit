<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Departments;
use App\Livewire\Contracts;
use App\Livewire\Posts;
// use App\Models\Contract;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/departments', Departments::class)->name('departments');
Route::get('/posts', Posts::class)->name('posts');

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
