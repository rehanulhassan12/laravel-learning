<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\School;
use App\Models\ClassRoom;

class DashboardController extends Controller
{
    /**
     * Show dashboard with attendance aggregation.
     */
    public function index(Request $request)
    {
        $schoolId = $request->school_id;
        $classId  = $request->class_id;

        // Get all schools for filter dropdown
        $schools = School::all();

        // Attendance query
        $query = Attendence::query();

        if ($schoolId) {
            $query->whereHas('classRoom', function($q) use ($schoolId){
                $q->where('school_id', $schoolId);
            });
        }

        if ($classId) {
            $query->where('class_id', $classId);
        }

        // Aggregate attendance per day
        $attendanceData = $query->selectRaw('date,
                                    SUM(CASE WHEN status="present" THEN 1 ELSE 0 END) as present_count,
                                    SUM(CASE WHEN status="absent" THEN 1 ELSE 0 END) as absent_count')
                                ->groupBy('date')
                                ->orderBy('date', 'desc')
                                ->get();

        return view('dashboard.index', compact('attendanceData', 'schools', 'schoolId', 'classId'));
    }

    /**
     * Fetch classes dynamically based on school (AJAX).
     */
    public function getClasses(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id'
        ]);

        $classes = ClassRoom::where('school_id', $request->school_id)
            ->select('id', 'name', 'session_year', 'section')
            ->get()
            ->map(function($c) {
                return [
                    'id' => $c->id,
                    'label' => "{$c->name} | {$c->session_year} | {$c->section}"
                ];
            });

        return response()->json($classes);
    }
}
