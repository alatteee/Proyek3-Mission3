<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\CourseController as StuCourse;
use App\Http\Controllers\Student\DashboardController as StuDash;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }
    return view('landing'); // -> resources/views/landing.blade.php
})->name('landing');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('courses', CourseController::class);   
        Route::resource('students', StudentController::class); 

    });

// BENAR
Route::middleware(['auth','role:student'])
    ->prefix('student')->as('student.')
    ->group(function () {
        Route::get('/', [StuDash::class, 'index'])->name('dashboard');   // <— pakai controller
        Route::get('/courses', [StuCourse::class, 'index'])->name('courses.index');
        Route::post('/courses/{course}/enroll', [StuCourse::class, 'enroll'])->name('courses.enroll');
        Route::get('/my-courses', [StuCourse::class, 'mine'])->name('courses.mine');
        Route::delete('/my-courses/{course}', [StuCourse::class, 'drop'])->name('courses.drop');
    });


require __DIR__.'/auth.php';
