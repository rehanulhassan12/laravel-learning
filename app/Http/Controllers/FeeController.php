<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\School;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    // Yearly fee form & list
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

        $existingFee = Fee::where('class_id', $class->id)
            ->where('school_id', $class->school_id)
            ->where('year', $request->year)
            ->first();

        if ($existingFee) {
            return redirect()->back()->with('error', 'Fee for this class and year already exists. Please update it instead.');
        }

        // Create yearly fee
        $fee = Fee::create([
            'school_id' => $class->school_id,
            'class_id' => $class->id,
            'year' => $request->year,
            'yearly_amount' => $request->yearly_amount,
            'monthly_amount' => $monthly_amount
        ]);

        // Generate monthly fees for all students
        foreach ($class->students as $student) {
            for ($m = 1; $m <= 12; $m++) {
                StudentFee::create([
                    'student_id' => $student->id,
                    'fee_id' => $fee->id,
                    'month' => date('F', mktime(0, 0, 0, $m, 1)),
                    'year' => $request->year,
                    'amount' => $monthly_amount
                ]);
            }
        }

        return redirect()->back()->with('success', 'Yearly fee set and monthly fees generated.');
    }

    // Inline yearly fee update
    public function update(Request $request, $id)
    {
        $request->validate([
            'yearly_amount' => 'required|numeric|min:0'
        ]);

        $fee = Fee::findOrFail($id);
        $fee->yearly_amount = $request->yearly_amount;
        $fee->monthly_amount = round($request->yearly_amount / 12, 2);
        $fee->save();

        // Update monthly amounts
        StudentFee::where('fee_id', $fee->id)->where('year', $fee->year)
            ->update(['amount' => $fee->monthly_amount]);

        return response()->json(['success' => true, 'monthly_amount' => $fee->monthly_amount]);
    }

    // Monthly collection page
      public function monthlyCollection(Request $request)
    {
        $month = $request->month ?? date('F');
        $year  = $request->year ?? date('Y');

        $school_id = $request->school_id;
        $class_id  = $request->class_id;

        // Ensure monthly fees exist
        $students = Student::when($school_id, fn($q) =>
                $q->whereHas('classRoom', fn($q2) =>
                    $q2->where('school_id', $school_id)
                )
            )
            ->when($class_id, fn($q) => $q->where('class_id', $class_id))
            ->get();

        foreach ($students as $student) {
            $fee = Fee::where('class_id', $student->class_id)
                ->where('year', $year)
                ->first();

            if (!$fee) continue;

            StudentFee::firstOrCreate([
                'student_id' => $student->id,
                'fee_id'     => $fee->id,
                'month'      => $month,
                'year'       => $year,
            ], [
                'amount' => $fee->monthly_amount
            ]);
        }

        // Unpaid fees
        $fees = StudentFee::with('student.classRoom.school')
            ->where('month', $month)
            ->where('year', $year)
            ->where('is_paid', false)
            ->when($school_id, fn($q) =>
                $q->whereHas('student.classRoom', fn($q2) =>
                    $q2->where('school_id', $school_id)
                )
            )
            ->when($class_id, fn($q) =>
                $q->whereHas('student.classRoom', fn($q2) =>
                    $q2->where('id', $class_id)
                )
            )
            ->get();

        $schools = School::all();
        $classes = ClassRoom::all();

        return view('fees.monthly_collection', compact(
            'fees',
            'month',
            'year',
            'schools',
            'classes',
            'school_id',
            'class_id'
        ));
    }


    // Mark paid
   public function markPaid(Request $request, $id)
    {
        $fee = StudentFee::findOrFail($id);

        $fee->update([
            'is_paid' => true,
            'paid_at' => now(),
            'amount'  => $request->amount ?? $fee->amount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment marked as paid'
        ]);
    }

    // Confirmed payments

    public function confirmedPayments(Request $request)
{
    $school_id = $request->school_id;
    $class_id  = $request->class_id;
    $month     = $request->month;
    $year      = $request->year;

    $query = StudentFee::with('student.classRoom.school')
        ->where('is_paid', true);

    if ($year) {
        $query->where('year', $year);
    }

    if ($month) {
        $query->where('month', $month);
    }

    if ($school_id) {
        $query->whereHas('student.classRoom', fn ($q) =>
            $q->where('school_id', $school_id)
        );
    }

    if ($class_id) {
        $query->whereHas('student.classRoom', fn ($q) =>
            $q->where('id', $class_id)
        );
    }

    $payments = $query->orderBy('paid_at', 'desc')->get();

    $schools = School::all();
    $classes = ClassRoom::all();

    return view('fees.confirmed_payments', compact(
        'payments',
        'schools',
        'classes'
    ));
}
}
