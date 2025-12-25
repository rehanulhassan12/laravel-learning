<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreenRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
   public function index() {
    $screens = Screen::with('parent')->get();
    return view('screens.index', compact('screens'));
}

public function create() {
    $parents = Screen::whereNull('parent_id')->get();
    return view('screens.create', compact('parents'));
}

public function store(StoreScreenRequest $request) {
    Screen::create($request->validated());
    return redirect()->route('screens.index')->with('success','Screen created');
}

public function edit(Screen $screen) {
    $parents = Screen::whereNull('parent_id')->where('id','!=',$screen->id)->get();
    return view('screens.edit', compact('screen','parents'));
}

public function update(UpdateScreenRequest $request, Screen $screen) {
    $screen->update($request->validated());
    return redirect()->route('screens.index')->with('success','Screen updated');
}

public function destroy(Screen $screen) {
    $screen->delete();
    return redirect()->route('screens.index')->with('success','Screen deleted');
}


}
