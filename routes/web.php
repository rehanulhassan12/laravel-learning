<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolGroupController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassRoomController;
// use App\Http\Controllers\UserRoleController;
// use App\Http\Controllers\RoleScreenController;
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
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Users resource (no screen restriction for testing)

// Protected routes - auth only
Route::middleware(['auth'])->group(function () {
    Route::resource('school_groups', SchoolGroupController::class)
        ->middleware('screen:school_groups');

    Route::resource('schools', SchoolController::class)
        ->middleware('screen:schools');

    Route::resource('classes', ClassRoomController::class)
        ->middleware('screen:classes');

        Route::middleware('auth')->get('/student/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');


});

// Admin-only routes
Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('screens', ScreenController::class);
Route::resource('users', UserController::class);
Route::resource('guardians', GuardianController::class);
Route::resource('students', StudentController::class);


    // // User roles management
    // Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])
    //     ->name('users.roles.edit');
    // Route::put('users/{user}/roles', [UserRoleController::class, 'update'])
    //     ->name('users.roles.update');

    // // Role screens management
    // Route::get('roles/{role}/screens', [RoleScreenController::class, 'edit'])
    //     ->name('roles.screens.edit');
    // Route::put('roles/{role}/screens', [RoleScreenController::class, 'update'])
    //     ->name('roles.screens.update');
});

