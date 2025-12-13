<?php

namespace App\Http\Controllers;


use App\Models\School;
use App\Models\SchoolGroup;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;


class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $schools = School::with("group")->get();
        return view("schools.index", compact("schools"));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = SchoolGroup::all();
        return view("schools.create", compact("groups"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        School::create(($request->validated()));

        return redirect()->route("schools.index")->with("success","Group created successfully.");
      
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
        return view("schools.show", compact("school"));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
       $groups = SchoolGroup::all();
        return view("schools.edit", compact("groups","school"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school) 
    {
        //
        $school->update($request->validated());

        return redirect()->route("schools.index")->with("success","School group updated successfully.");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
        $school->delete();
        return redirect()->route("schools.index")->with("success","Group deleted successfully.");
    }
}
