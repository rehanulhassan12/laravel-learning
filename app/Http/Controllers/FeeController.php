<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    // Show form & list of existing fees
    public function create()
    {
        $classes = ClassRoom::with('school')->get();
        $fees = Fee::with('classRoom.school')->orderBy('year', 'desc')->get();
        return view('fees.create', compact('classes', 'fees'));
    }

    // Store yearly fee
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'year' => 'required|digits:4',
            'yearly_amount' => 'required|numeric|min:0',
        ]);

        $class = ClassRoom::findOrFail($request->class_id);
        $monthly_amount = round($request->yearly_amount / 12, 2);

        // Prevent duplicate entries
        $existingFee = Fee::where('class_id', $class->id)
            ->where('school_id', $class->school_id)
            ->where('year', $request->year)
            ->first();

        if ($existingFee) {
            return redirect()->back()->with('error', 'Fee for this class and year already exists. Please update it instead.');
        }

        // Create new fee
        $fee = Fee::create([
            'school_id' => $class->school_id,
            'class_id' => $class->id,
            'year' => $request->year,
            'yearly_amount' => $request->yearly_amount,
            'monthly_amount' => $monthly_amount
        ]);

        // Generate monthly fees
        foreach ($class->students as $student) {
            for ($m = 1; $m <= 12; $m++) {
                StudentFee::create([
                    'student_id' => $student->id,
                    'fee_id' => $fee->id,
                    'month' => date('F', mktime(0,0,0,$m,1)),
                    'year' => $request->year,
                    'amount' => $monthly_amount
                ]);
            }
        }

        return redirect()->back()->with('success', 'Yearly fee set and monthly fees generated.');
    }

    // Inline update via AJAX
    public function update(Request $request, $id)
    {
        $request->validate([
            'yearly_amount' => 'required|numeric|min:0'
        ]);

        $fee = Fee::findOrFail($id);
        $fee->yearly_amount = $request->yearly_amount;
        $fee->monthly_amount = round($request->yearly_amount / 12, 2);
        $fee->save();

        // Update all student fees for this fee id and year
        StudentFee::where('fee_id', $fee->id)
            ->where('year', $fee->year)
            ->update(['amount' => $fee->monthly_amount]);

        return response()->json(['success' => true, 'monthly_amount' => $fee->monthly_amount]);
    }
}
