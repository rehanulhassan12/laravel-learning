<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use App\Models\User;
use App\Models\Role;
use App\Models\ClassRoom;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is.admin')->except('dashboard');
    }

    public function index()
    {
        $students = Student::with(['guardian', 'classRoom.school', 'user'])->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.form', [
            'student' => null,
            'schools' => School::all(),
            'classes' => ClassRoom::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_email' => 'required|email|unique:users,email',
            'roll_no' => 'required',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'class_id' => 'required|exists:classes,id',

            'guardian_name' => 'required',
            'guardian_email' => 'required|email',
            'guardian_phone' => 'required',
            'guardian_relation' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            // STUDENT USER
            $studentUser = User::create([
                'name' => $request->name,
                'email' => $request->user_email,
                'password' => Hash::make('password123'),
            ]);

            $studentUser->roles()->attach(
                Role::where('name', 'student')->first()->id
            );

            // GUARDIAN USER
            $guardianUser = User::create([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
                'password' => Hash::make('password123'),
            ]);

            $guardianUser->roles()->attach(
                Role::where('name', 'guardian')->first()->id
            );

            $guardian = Guardian::create([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
                'phone' => $request->guardian_phone,
                'relation' => $request->guardian_relation,
                'address' => $request->guardian_address,
                'user_id' => $guardianUser->id,
            ]);

            Student::create([
                'name' => $request->name,
                'roll_no' => $request->roll_no,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'class_id' => $request->class_id,
                'guardian_id' => $guardian->id,
                'user_id' => $studentUser->id,
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Student created');
    }

    public function edit(Student $student)
    {
        $student->load('guardian', 'user', 'classRoom.school');

        return view('students.form', [
            'student' => $student,
            'schools' => School::all(),
            'classes' => ClassRoom::all(),
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'user_email' => 'required|email',
            'roll_no' => 'required',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($request, $student) {

            $student->user->update([
                'name' => $request->name,
                'email' => $request->user_email,
            ]);

            $student->guardian->user->update([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
            ]);

            $student->guardian->update([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
                'phone' => $request->guardian_phone,
                'relation' => $request->guardian_relation,
                'address' => $request->guardian_address,
            ]);

            $student->update([
                'name' => $request->name,
                'roll_no' => $request->roll_no,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'class_id' => $request->class_id,
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Student updated');
    }
}
