<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\School;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('school', 'user')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $schools = School::all();
        return view('teachers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'specialization' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'school_id' => 'required|exists:schools,id',
        ]);

        DB::transaction(function() use ($request) {

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->user_email,
                'password' => Hash::make('password123'), // default password
            ]);
            $teacherRole = Role::where('name', 'teacher')->first();
            if ($teacherRole) $user->roles()->attach($teacherRole->id);

            // Create teacher
            Teacher::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'specialization' => $request->specialization,
                'dob' => $request->dob,
                'school_id' => $request->school_id,
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $schools = School::all();
        $teacher->load('user');
        return view('teachers.edit', compact('teacher', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'specialization' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'school_id' => 'required|exists:schools,id',
        ]);

        DB::transaction(function() use ($request, $teacher) {
            // Update linked user
            $teacher->user->update([
                'name' => $request->name,
                'email' => $request->user_email,
            ]);

            // Update teacher
            $teacher->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'specialization' => $request->specialization,
                'dob' => $request->dob,
                'school_id' => $request->school_id,
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function() use ($teacher) {
            if ($teacher->user) {
                $teacher->user->roles()->detach();
                $teacher->user->delete();
            }
            $teacher->delete();
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('school', 'user');
        return view('teachers.show', compact('teacher'));
    }
}
