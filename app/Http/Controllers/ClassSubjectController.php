<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\School;


class ClassSubjectController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::all();
        $selectedSchool = $request->school_id
            ? School::find($request->school_id)
            : null;

        $classes = $selectedSchool
            ? ClassRoom::with('subjects')->where('school_id', $selectedSchool->id)->get()
            : collect();

        $subjects = Subject::all();

        return view('class-subjects.index', compact('schools','selectedSchool','classes','subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $class = ClassRoom::findOrFail($request->class_id);
        $class->subjects()->syncWithoutDetaching($request->subject_ids);

        return back()->with('success','Subjects assigned to class successfully.');
    }

    public function destroy($classId, $subjectId)
    {
        $class = ClassRoom::findOrFail($classId);
        $class->subjects()->detach($subjectId);

        return back()->with('success','Subject removed from class.');
    }
}
