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
    public function index()
    {
        $students = Student::with(['guardian', 'classRoom.school', 'user'])->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $guardians = Guardian::all();
        $classes = ClassRoom::with('school')->get();
        $users = User::all();

        return view('students.create', compact('guardians', 'classes', 'users'));
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['guardian', 'classRoom.school', 'user']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $guardians = Guardian::all();
        $classes = ClassRoom::with('school')->get();
        $users = User::all();

        return view('students.edit', compact('student', 'guardians', 'classes', 'users'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function dashboard()
    {
        $student = Auth::user()->student()->with(['classRoom.school', 'guardian'])->firstOrFail();
        return view('students.dashboard', compact('student'));
    }
}
