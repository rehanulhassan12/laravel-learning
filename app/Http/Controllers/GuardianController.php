<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Http\Requests\StoreGuardianRequest;
use App\Http\Requests\UpdateGuardianRequest;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::all();
        return view('guardians.index', compact('guardians'));
    }

    public function create()
    {
        return view('guardians.create');
    }

    public function store(StoreGuardianRequest $request)
    {
        Guardian::create($request->validated());

        return redirect()
            ->route('guardians.index')
            ->with('success', 'Guardian created successfully.');
    }

    public function show(Guardian $guardian)
    {
        return view('guardians.show', compact('guardian'));
    }

    public function edit(Guardian $guardian)
    {
        return view('guardians.edit', compact('guardian'));
    }

    public function update(UpdateGuardianRequest $request, Guardian $guardian)
    {
        $guardian->update($request->validated());

        return redirect()
            ->route('guardians.index')
            ->with('success', 'Guardian updated successfully.');
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();

        return redirect()
            ->route('guardians.index')
            ->with('success', 'Guardian deleted successfully.');
    }
}

