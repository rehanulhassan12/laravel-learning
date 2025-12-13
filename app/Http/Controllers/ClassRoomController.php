<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\School;
use App\Http\Requests\StoreClassRoomRequest;
use App\Http\Requests\UpdateClassRoomRequest;


class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $classes = ClassRoom::with("school")->get();
        return view("classes.index", compact("classes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        return view("classes.create", compact("schools"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassRoomRequest $request)
    {
         ClassRoom::create($request->validated());

        return redirect()->route("classes.index")->with("success","Class created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $class)
    {
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $class)
    {
        $schools = School::all();
        return view("classes.edit", compact("schools","class"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassRoomRequest $request, ClassRoom $class)
    {
        //
        $class->update($request->validated());

        return redirect()->route("classes.index")->with("success","Class updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $class)
    {
        //
        $class->delete();
        return redirect()->route("classes.index")->with("success","Class deleted successfully.");
    }
}
