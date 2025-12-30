<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendence;
use App\Models\School;
use App\Models\ClassRoom;

class AttendenceController extends Controller
{
    // Show attendance page
    public function index()
    {
        $schools = School::all();
        return view('attendence.index', compact('schools'));
    }

    // Load students based on filters
    public function students(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id'  => 'required|exists:classes,id',
            'session'   => 'required',
            'section'   => 'required',
            'date'      => 'nullable|date',
        ]);

        $date = $request->date ?? now()->toDateString();

        $classRoom = ClassRoom::find($request->class_id);

        if (!$classRoom) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        $students = Student::whereHas('classRoom', function ($q) use ($classRoom, $request) {
                $q->where('name', $classRoom->name)
                  ->where('session_year', $request->session)
                  ->where('section', $request->section);
            })
            ->whereDoesntHave('attendences', function ($q) use ($date) {
                $q->where('date', $date);
            })
            ->with('classRoom')
            ->get();

        return view('attendence.partials.students', compact('students'));
    }

    // Store attendance
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id'   => 'required|exists:classes,id',
            'status'     => 'required|in:present,absent',
            'date'       => 'nullable|date',
        ]);
        Attendence::create([
            'student_id' => $request->student_id,
            'class_id'   => $request->class_id,
            'status'     => $request->status,
            'date'       => $request->date ?? now()->toDateString(),
            'marked_by'  => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    // List attendance records
   // Load attendance records based on filters (AJAX)
public function list(Request $request)
{
    $request->validate([
        'school_id' => 'required|exists:schools,id',
        'class_id'  => 'required|exists:classes,id',
        'session'   => 'required',
        'section'   => 'required',
        'date'      => 'required|date',
    ]);

    $query = Attendence::with('student.classRoom')
        ->where('date', $request->date) // filter by date
        ->whereHas('student.classRoom', function ($q) use ($request) {
            $q->where('school_id', $request->school_id)
              ->where('id', $request->class_id)
              ->where('session_year', $request->session)
              ->where('section', $request->section);
        });

    $attendances = $query->get();

    return view('attendence.partials.list', compact('attendances'));
}
// Show attendance list page with filters
public function listView()
{
    $schools = School::all();
    return view('attendence.list', compact('schools'));
}

// Update attendance
public function update(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendances,id',
        'status'        => 'required|in:present,absent',
    ]);

    $attendance = Attendence::find($request->attendance_id);
    $attendance->status = $request->status;
    $attendance->save();

    return response()->json(['success' => true]);
}

    // Get classes for school (AJAX)
    public function getClasses(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id'
        ]);

        $classes = ClassRoom::where('school_id', $request->school_id)
            ->groupBy('name')
            ->selectRaw('MIN(id) as id, name')
            ->get();

        return response()->json($classes);
    }

    // Get sessions for class (AJAX)
    public function getSessions(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id'
        ]);

        return response()->json(ClassRoom::getSessions($request->class_id));
    }

    // Get sections for class & session (AJAX)
    public function getSections(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'session'  => 'nullable',
        ]);

        return response()->json(ClassRoom::getSections($request->class_id, $request->session));
    }
}
