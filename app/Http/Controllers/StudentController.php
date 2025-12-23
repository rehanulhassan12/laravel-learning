<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use App\Models\ClassRoom;
use App\Models\User;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('is.admin')->except('dashboard');
    }

    // Admin-only: list all students
    public function index()
    {
        $students = Student::with(['guardian', 'classRoom.school', 'user'])->get();
        return view('students.index', compact('students'));
    }

    // Admin-only: show create form
    public function create()
    {
        $guardians = Guardian::all();
        $classes = ClassRoom::with('school')->get();
        $users = User::all();

        return view('students.create', compact('guardians', 'classes', 'users'));
    }

    // Admin-only: store new student
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();

        // Automatically set student name from selected user
        if (!empty($data['user_id'])) {
            $user = User::find($data['user_id']);
            $data['name'] = $user->name;
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    // Admin-only: show a student
    public function show(Student $student)
    {
        $student->load(['guardian', 'classRoom.school', 'user']);
        return view('students.show', compact('student'));
    }

    // Admin-only: edit form
    public function edit(Student $student)
    {
        $guardians = Guardian::all();
        $classes = ClassRoom::with('school')->get();
        $users = User::all();

        return view('students.edit', compact('student', 'guardians', 'classes', 'users'));
    }

    // Admin-only: update student
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();

        // Update name automatically from selected user
        if (!empty($data['user_id'])) {
            $user = User::find($data['user_id']);
            $data['name'] = $user->name;
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // Admin-only: delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    // Student dashboard: only accessible by logged-in student users
    public function dashboard()
    {
        $user = Auth::user();

        // Safely get related student record
        $student = $user->student;

        if (!$student) {
            abort(403, 'You are not authorized to access this page.');
        }

        // Eager load relations
        $student->load(['classRoom.school', 'guardian']);

        return view('students.dashboard', compact('student'));
    }
}
