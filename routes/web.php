<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Departments;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/departments', Departments::class)->name('departments');
// Route::get('/departments', function () {
//     return view('departments');
// })->name('departments');

// Route::middleware(['auth', 'check.permission:view departments'])->group(function () {
//     Route::get('/departments', function () {
//         return view('departments');
//     })->name('departments');
// });

require __DIR__ . '/auth.php';
