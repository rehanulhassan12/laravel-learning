<?php

namespace App\Http\Controllers;
use App\Models\SchoolGroup;

use App\Http\Requests\StoreSchoolGroupRequest;
use App\Http\Requests\UpdateSchoolGroupRequest;

use Illuminate\Http\Request;

class SchoolGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $groups = SchoolGroup::all();
    return view('school_groups.index', compact('groups'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('school_groups.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreSchoolGroupRequest $request)
{
    SchoolGroup::create($request->validated());

    return redirect()
        ->route('school_groups.index')
        ->with('success', 'Group created successfully.');
}
    /**
     * Display the specified resource.
     */
  public function show(SchoolGroup $school_group)
{
    return view('school_groups.show', compact('school_group'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(SchoolGroup $school_group)
{
    return view('school_groups.edit', compact('school_group'));
}
    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSchoolGroupRequest $request, SchoolGroup $school_group)
{
    $school_group->update($request->validated());

    return redirect()
        ->route('school_groups.index')
        ->with('success', 'Group updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(SchoolGroup $school_group)
{
    $school_group->delete();

    return redirect()
        ->route('school_groups.index')
        ->with('success', 'Group deleted successfully.');
}
}
