<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\School;

class TeacherSubjectController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::all();
        $selectedSchool = $request->school_id
            ? School::find($request->school_id)
            : null;

        $teachers = $selectedSchool
            ? Teacher::with('subjects')->where('school_id', $selectedSchool->id)->get()
            : collect();

        $subjects = Subject::all();

        return view('teacher-subjects.index', compact('schools', 'selectedSchool', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $teacher = Teacher::findOrFail($request->teacher_id);
        $teacher->subjects()->syncWithoutDetaching($request->subject_ids);

        return back()->with('success', 'Subjects assigned successfully.');
    }

    public function destroy($teacherId, $subjectId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $teacher->subjects()->detach($subjectId);

        return back()->with('success', 'Subject removed.');
    }
}

