<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\School;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('school')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $schools = School::all();
        return view('teachers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'specialization' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'school_id' => 'required|exists:schools,id',
        ]);

        Teacher::create($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher created.');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $schools = School::all();
        return view('teachers.edit', compact('teacher', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'specialization' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'school_id' => 'required|exists:schools,id', // validate school
        ]);

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted.');
    }
}
