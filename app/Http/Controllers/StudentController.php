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

    // List all students
    public function index()
    {
        $students = Student::with(['guardian', 'classRoom.school', 'user'])->get();
        return view('students.index', compact('students'));
    }

    // Show create form
    public function create()
    {
        return view('students.form', [
            'student' => null,
            'schools' => School::all(),
            'classes' => ClassRoom::all(),
        ]);
    }

    // Store new student + guardian + user
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

            // Create student user
            $studentUser = User::create([
                'name' => $request->name,
                'email' => $request->user_email,
                'password' => Hash::make('password123'),
            ]);
            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) $studentUser->roles()->attach($studentRole->id);

            // Create guardian user
            $guardianUser = User::create([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
                'password' => Hash::make('password123'),
            ]);
            $guardianRole = Role::where('name', 'guardian')->first();
            if ($guardianRole) $guardianUser->roles()->attach($guardianRole->id);

            // Create guardian record
            $guardian = Guardian::create([
                'name' => $request->guardian_name,
                'email' => $request->guardian_email,
                'phone' => $request->guardian_phone,
                'relation' => $request->guardian_relation,
                'address' => $request->guardian_address,
                'user_id' => $guardianUser->id,
            ]);

            // Create student record
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

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    // Show edit form
    public function edit(Student $student)
    {
        $student->load('guardian', 'user', 'classRoom.school');

        return view('students.form', [
            'student' => $student,
            'schools' => School::all(),
            'classes' => ClassRoom::all(),
        ]);
    }

    // Update student + guardian + users
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

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // Show single student
    public function show(Student $student)
    {
        $student->load('guardian', 'user', 'classRoom.school');

        return view('students.show', compact('student'));
    }

    // Optional: student dashboard
    public function dashboard()
    {
        $student = auth()->user()->student;
        if (!$student) abort(403, 'Unauthorized');
        $student->load('guardian', 'classRoom.school');
        return view('students.dashboard', compact('student'));
    }
    // Delete student, guardian, and linked users
public function destroy(Student $student)
{
    DB::transaction(function () use ($student) {

        // Delete student user
        if ($student->user) {
            $student->user->roles()->detach(); // detach roles
            $student->user->delete();
        }

        // Delete guardian user and guardian record
        if ($student->guardian) {
            if ($student->guardian->user) {
                $student->guardian->user->roles()->detach();
                $student->guardian->user->delete();
            }
            $student->guardian->delete();
        }

        // Delete student record
        $student->delete();
    });

    return redirect()->route('students.index')->with('success', 'Student and linked Guardian deleted successfully.');
}

}
