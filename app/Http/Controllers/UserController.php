<?php

namespace App\Http\Controllers;
use App\Models\User;


use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view("users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name'     => 'required|max:50',
        'email'    => 'required|email|max:50|unique:users',
        'password' => 'required|string|min:6',
    ]);

    // Create user
    User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => bcrypt($validated['password']), // hash password
    ]);

    // Redirect with success message
    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         $user = User::findOrFail($id);
    return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $user = User::findOrFail($id); // safer than find()

    // Validate input
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:6',
    ]);

    // Update user
    $user->update([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
    ]);

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
