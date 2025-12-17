<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolGroupController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RoleScreenController;
use App\Http\Controllers\ScreenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Public route
Route::get('/', fn() => view('welcome'));

// Auth routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
    Route::resource('users', UserController::class)  ;


// Protected routes - only auth required for testing
Route::middleware(['auth'])->group(function () {

    // Resources
    // Route::resource('users', UserController::class);
  Route::resource('school_groups', SchoolGroupController::class)
 ->middleware('screen:school_groups');

Route::resource('schools', SchoolController::class)
 ->middleware('screen:schools');

Route::resource('classes', ClassRoomController::class)
 ->middleware('screen:classes');

    // Screens
    Route::resource('screens', ScreenController::class);
    Route::resource('roles', RoleController::class);

    // User roles management
    Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])
        ->name('users.roles.edit');
    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])
        ->name('users.roles.update');

    // Role screens management
    Route::get('roles/{role}/screens', [RoleScreenController::class, 'edit'])
        ->name('roles.screens.edit');
    Route::put('roles/{role}/screens', [RoleScreenController::class, 'update'])
        ->name('roles.screens.update');
});
