<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreScreenRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\Models\Screen;
use Illuminate\Http\Request;



class ScreensController extends Controller
{
    public function create() {
    $parents = Screen::whereNull('parent_id')->with('children')->get();

    return view('screens.create', compact('parents'));
}

public function store(StoreScreenRequest $request) {
    Screen::create($request->validated());
    return redirect()->route('screens.index')->with('success','Screen created');
}
}
