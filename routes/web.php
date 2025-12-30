<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolGroupController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScreensController;
use App\Http\Controllers\AttendenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public route
Route::get('/', fn() => view('welcome'));




// Auth routes
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name("login");
  Route::get('/register', [AuthController::class, 'showRegisterForm'])->name("register");
  Route::middleware('guest')->group(function () {

  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/register', [AuthController::class, 'register']);
});


 Route::post('logout', [AuthController::class, 'logout'])->name('logout');





// Users resource

// Protected routes - auth only
    Route::middleware(['auth'])->group(function () {
    Route::resource('school_groups', SchoolGroupController::class)
        ->middleware('screen:School Groups');

    Route::resource('schools', SchoolController::class)
        ->middleware('screen:schools');

    Route::resource('classes', ClassRoomController::class)
        ->middleware('screen:classes');

    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');


});


Route::get('/attendance/students', [AttendenceController::class, 'index'])
    ->name('attendance.students');

Route::get('/attendance/get-classes', [AttendenceController::class, 'getClasses'])
    ->name('attendance.students.getClasses');

Route::get('/attendance/get-sessions', [AttendenceController::class, 'getSessions'])
    ->name('attendance.students.getSessions');

Route::get('/attendance/get-sections', [AttendenceController::class, 'getSections'])
    ->name('attendance.students.getSections');

Route::post('/attendance/student', [AttendenceController::class, 'students'])
    ->name('attendance.student');

Route::post('/attendance/store', [AttendenceController::class, 'store'])
    ->name('attendance.students.store');


// Admin-only routes
    Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);
    Route::resource('guardians', GuardianController::class);
     Route::resource('students', StudentController::class);
    Route::resource('screens', ScreenController::class);

});

