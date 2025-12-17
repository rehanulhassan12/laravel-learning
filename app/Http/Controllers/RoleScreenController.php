<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Screen;
use Illuminate\Http\Request;

class RoleScreenController extends Controller
{
    //
     public function edit(Role $role)
    {
        $screens = Screen::all();
        return view('role_screens.edit', compact('role','screens'));
    }

     public function update(Request $request, Role $role)
    {
        $request->validate([
            'screens' => 'array',
            'screens.*' => 'exists:screens,id',
        ]);

        $role->screens()->sync($request->screens);
        return redirect()->route('roles.index')->with('success','Screens updated');
    }
}

