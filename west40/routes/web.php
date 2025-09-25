<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class)->except(['show']);
    Route::post('students/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
    Route::delete('students/{id}/delete', [StudentController::class, 'delete'])->name('students.delete');
    Route::resource('users', UserController::class)->except(['show']);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');
});

require __DIR__ . '/auth.php';
