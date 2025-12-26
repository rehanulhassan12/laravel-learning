<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreenRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    // Display list of screens
    public function index()
    {
        $screens = Screen::with('children')->get();
        return view('screens.index', compact('screens'));
    }

    // Show form to create a new screen
    public function create()
    {
        $parents = Screen::whereNull('parent_id')->with('children')->get();
        return view('screens.create', compact('parents'));
    }

    // Store a new screen
    public function store(StoreScreenRequest $request)
    {
        Screen::create($request->validated());
        return redirect()->route('screens.index')->with('success', 'Screen created successfully');
    }

    // Show a specific screen
    public function show(Screen $screen)
    {
        return view('screens.show', compact('screen'));
    }

    // Show form to edit a screen
    public function edit(Screen $screen)
    {
        $parents = Screen::whereNull('parent_id')->with('children')->get();
        return view('screens.edit', compact('screen', 'parents'));
    }

    // Update a screen
    public function update(UpdateScreenRequest $request, Screen $screen)
    {
        $screen->update($request->validated());
        return redirect()->route('screens.index')->with('success', 'Screen updated successfully');
    }

    // Delete a screen
    public function destroy(Screen $screen)
    {
        $screen->delete();
        return redirect()->route('screens.index')->with('success', 'Screen deleted successfully');
    }
}
