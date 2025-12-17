<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    //
     public function edit(User $user)
    {
        $roles = Role::all();
        return view('user_roles.edit', compact('user','roles'));
    }
      public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($request->roles); // attach selected roles
        return redirect()->route('users.index')->with('success','Roles updated');
    }

}
