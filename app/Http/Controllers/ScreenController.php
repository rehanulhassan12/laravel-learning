<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreenRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $screens = Screen::all();
        return view('screens.index', compact('screens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        //
         return view('screens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreenRequest $request)
    {
        //
          Screen::create($request->validated());
        return redirect()->route('screens.index')->with('success','Screen created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Screen $screen)
    {
        //
          return view('screens.show', compact('screen'));
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screen $screen)
    {
        //
          return view('screens.edit', compact('screen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreenRequest $request, Screen $screen)
    {
        //
         $screen->update($request->validated());
        return redirect()->route('screens.index')->with('success','Screen updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screen $screen)
    {
        //
          $screen->delete();
        return redirect()->route('screens.index')->with('success','Screen deleted');
    }
}
