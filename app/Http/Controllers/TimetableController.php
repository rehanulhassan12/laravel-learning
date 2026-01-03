<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Period;
use App\Models\Timetable;
use App\Models\ClassRoom;
use App\Models\School;

class TimetableController extends Controller
{
       public function index()
    {
        $timetables = Timetable::with(['teacher','subject','period','classRoom','school'])->get();

        $schools = School::all();
        return view('timetables.index', compact('timetables','schools'));
    }



    public function create()
    {
        $schools = School::all();
        $subjects = Subject::all();
        $periods = Period::all();
        return view('timetables.create', compact('schools','subjects','periods'));
    }


     public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id'=>'required|exists:classes,id',
            'subject_id'=>'required|exists:subjects,id',
            'teacher_id'=>'required|exists:teachers,id',
            'period_id'=>'required|exists:periods,id',
            'day'=>'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
        ]);

        // check teacher availability
        $exists = Timetable::where('teacher_id', $data['teacher_id'])
            ->where('day', $data['day'])
            ->where('period_id', $data['period_id'])
            ->where('class_id', $data['class_id'])
            ->exists();

        if($exists){
            return back()->withErrors(['teacher_id'=>'Teacher already assigned for this period in this class.'])->withInput();
        }

        Timetable::create($data);

        return redirect()->route('timetables.index')->with('success','Timetable assigned.');
    }

    public function edit(Timetable $timetable)
    {
        $schools = School::all();
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $periods = Period::all();
        $teachers = Teacher::all();
        return view('timetables.edit', compact('timetable','schools','classes','subjects','periods','teachers'));
    }

   public function update(Request $request, Timetable $timetable)
{
    $data = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'class_id' => 'required|exists:classes,id',
        'subject_id' => 'required|exists:subjects,id',
        'teacher_id' => 'required|exists:teachers,id',
        'period_id' => 'required|exists:periods,id',
        'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
    ]);

    $exists = Timetable::where('teacher_id', $data['teacher_id'])
        ->where('day', $data['day'])
        ->where('period_id', $data['period_id'])
        ->where('class_id', $data['class_id'])
        ->where('id', '!=', $timetable->id)
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'teacher_id' => 'Teacher already assigned for this period in this class.'
        ])->withInput();
    }

    $timetable->update($data);

    return redirect()->route('timetables.index')->with('success', 'Timetable updated.');
}


    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetables.index')->with('success','Timetable deleted.');
    }

    // AJAX for dynamic teacher dropdown
public function availableTeachers(Request $request)
{
    $schoolId = $request->school_id;
    $classId = $request->class_id;
    $subjectId = $request->subject_id;
    $day = $request->day;
    $periodId = $request->period_id;

    if (!$schoolId || !$classId || !$subjectId || !$day || !$periodId) {
        return response()->json([]);
    }

    $class = ClassRoom::find($classId);

    // check if the subject is assigned to this class
    if (!$class->subjects()->where('subjects.id', $subjectId)->exists()) {
        return response()->json([]);
    }

    $teachers = Teacher::where('school_id', $schoolId)
        ->whereHas('subjects', function($q) use ($subjectId) {
            $q->where('subjects.id', $subjectId);
        })
        ->get();

    // filter out teachers already assigned to this class/day/period
    $timetableId = $request->timetable_id;

$available = $teachers->filter(function ($teacher) use ($day, $periodId, $classId, $timetableId) {
    return !$teacher->timetables()
        ->where('day', $day)
        ->where('period_id', $periodId)
        ->where('class_id', $classId)
        ->when($timetableId, fn ($q) => $q->where('id', '!=', $timetableId))
        ->exists();
});

    return response()->json($available->values());
}




}
