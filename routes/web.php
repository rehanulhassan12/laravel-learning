<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolGroupController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassRoomController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::resource('schools', SchoolController::class);
Route::resource('classes', ClassRoomController::class);
Route::resource('school_groups', SchoolGroupController::class);


