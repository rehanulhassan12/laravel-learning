<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
          $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }


    public function create()
    {
        return view('subjects.create');
    }


    public function store(Request $request)
    {
            $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subject::create($data);
        return redirect()->route('subjects.index')->with('success', 'Subject created.');
    }


    public function show(Subject $subject)
    {
         return view('subjects.show', compact('subject'));
    }


    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));

    }

    public function update(Request $request, Subject $subject)
    {
            $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update($data);
        return redirect()->route('subjects.index')->with('success', 'Subject updated.');

    }


    public function destroy(Subject $subject)
    {
             $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted.');
    }
}
