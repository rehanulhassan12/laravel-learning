<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Screen;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('screens')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $screens = Screen::all();
        return view('roles.create', compact('screens'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        // attach screens
        $role->screens()->sync($request->screens ?? []);

        return redirect()->route('roles.index')->with('success','Role created');
    }

    public function show(Role $role)
    {
        $role->load('screens');
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $screens = Screen::all();
        $roleScreens = $role->screens->pluck('id')->toArray();

        return view('roles.edit', compact('role','screens','roleScreens'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        // sync screens
        $role->screens()->sync($request->screens ?? []);

        return redirect()->route('roles.index')->with('success','Role updated');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success','Role deleted');
    }
}
