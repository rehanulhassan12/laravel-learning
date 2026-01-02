<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Period;
use App\Models\Timetable;
use App\Models\ClassRoom;
use Illuminate\Http\Request;


class TimetableController extends Controller
{

    public function index()
    {
        $timetables = Timetable::with(['teacher','subject','period','class'])->get();
        return view('timetables.index', compact('timetables'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $periods = Period::all();
        return view('timetables.create', compact('classes','subjects','periods'));
    }


    public function store(Request $request)
    {
         $data = $request->validate([
            'class_id'=>'required|exists:classes,id',
            'subject_id'=>'required|exists:subjects,id',
            'teacher_id'=>'required|exists:teachers,id',
            'period_id'=>'required|exists:periods,id',
            'day'=>'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
        ]);
          $exists = Timetable::where('teacher_id', $data['teacher_id'])
            ->where('day', $data['day'])
            ->where('period_id', $data['period_id'])
            ->exists();


        if($exists){
            return back()->withErrors(['teacher_id'=>'Teacher already assigned for this period.'])->withInput();
        }
          Timetable::create($data);
        return redirect()->route('timetables.index')->with('success','Timetable assigned.');



    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $periods = Period::all();
        $teachers = Teacher::all();
        return view('timetables.edit', compact('timetable','classes','subjects','periods','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Timetable $timetable)
    {
         $data = $request->validate([
            'class_id'=>'required|exists:classes,id',
            'subject_id'=>'required|exists:subjects,id',
            'teacher_id'=>'required|exists:teachers,id',
            'period_id'=>'required|exists:periods,id',
            'day'=>'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
        ]);
          $exists = Timetable::where('teacher_id', $data['teacher_id'])
            ->where('day', $data['day'])
            ->where('period_id', $data['period_id'])
            ->where('id','!=',$timetable->id)
            ->exists();

        if($exists){
            return back()->withErrors(['teacher_id'=>'Teacher already assigned for this period.'])->withInput();
        }
          $timetable->update($data);
        return redirect()->route('timetables.index')->with('success','Timetable updated.');
    }


    public function destroy(Timetable $timetable)
    {
         $timetable->delete();
        return redirect()->route('timetables.index')->with('success','Timetable deleted.');

    }
    public function availableTeachers(Request $request)
{
    $subjectId = $request->subject_id;
    $day = $request->day;
    $periodId = $request->period_id;

    if(!$subjectId || !$day || !$periodId){
        return response()->json([]);
    }

    $teachers = Teacher::whereHas('subjects', function($q) use($subjectId){
        $q->where('subjects.id', $subjectId);
    })->get();

    $available = $teachers->filter(function($teacher) use($day, $periodId){
        return ! $teacher->timetables()
            ->where('day', $day)
            ->where('period_id', $periodId)
            ->exists();
    });

    return response()->json($available->values());
}

}
