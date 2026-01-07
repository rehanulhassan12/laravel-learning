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
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherSubjectController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;


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

// Dashboard route
Route::get('/dashboard.index', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/get-classes', [DashboardController::class, 'getClasses'])->name('dashboard.getClasses');


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


Route::get('/attendance', [AttendenceController::class, 'index'])
    ->name('attendance.index');

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


Route::get('/attendance/list', [AttendenceController::class, 'listView'])->name('attendance_list.index');

Route::post('/attendance/list/data', [AttendenceController::class, 'list'])
    ->name('attendance.list.data');
Route::post('/attendance/update', [AttendenceController::class, 'update'])
    ->name('attendance.update');

    Route::resource('teachers', TeacherController::class);
    Route::resource('subjects', SubjectController::class);
    Route::get('teacher-subjects', [TeacherSubjectController::class, 'index'])
    ->name('teacher-subjects.index');

Route::post('teacher-subjects', [TeacherSubjectController::class, 'store'])
    ->name('teacher-subjects.store');

Route::delete('teacher-subjects/{teacher}/{subject}',
    [TeacherSubjectController::class, 'destroy']
)->name('teacher-subjects.destroy');
Route::get('/timetables/available-teachers', [TimetableController::class, 'availableTeachers'])
    ->name('timetables.available-teachers');
Route::resource('timetables', TimetableController::class);


Route::get('/class-subjects', [ClassSubjectController::class, 'index'])->name('class-subjects.index');
Route::post('/class-subjects', [ClassSubjectController::class, 'store'])->name('class-subjects.store');
Route::delete('/class-subjects/{class}/{subject}', [ClassSubjectController::class, 'destroy'])->name('class-subjects.destroy');
Route::get('fees/create', [FeeController::class, 'create'])->name('fees.create');

Route::post('fees', [FeeController::class, 'store'])->name('fees.store');
Route::post('fees/{id}/update', [FeeController::class, 'update'])->name('fees.update');

Route::get('students/{student}/fees', [FeeController::class, 'studentFees'])->name('student.fees');
Route::post('student_fees/{id}/paid', [FeeController::class, 'markPaid'])->name('student_fees.markPaid');



// Admin-only routes
    Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);
    Route::resource('guardians', GuardianController::class);
     Route::resource('students', StudentController::class);
    Route::resource('screens', ScreenController::class);

});

