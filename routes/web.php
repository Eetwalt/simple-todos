<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('tasks', 'tasks')
    ->middleware(['auth', 'verified'])
    ->name('tasks');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
