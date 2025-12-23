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
        ->middleware('screen:school_groups');

    Route::resource('schools', SchoolController::class)
        ->middleware('screen:schools');

    Route::resource('classes', ClassRoomController::class)
        ->middleware('screen:classes');

        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');


});

// Admin-only routes
Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('screens', ScreenController::class);
Route::resource('users', UserController::class);
Route::resource('guardians', GuardianController::class);
Route::resource('students', StudentController::class);



});

