<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfficeController extends Controller
{
    public function index(): View
    {
        $offices = Office::query()
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return view('admin.offices.index', compact('offices'));
    }

    public function create(): View
    {
        return view('admin.offices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:offices,name'],
        ]);

        $office = Office::create($validated);

        return redirect()->route('admin.offices.index')->with('success', "{$office->name} created successfully.");
    }

    public function edit(Office $office): View
    {
        return view('admin.offices.edit', compact('office'));
    }

    public function update(Request $request, Office $office): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:offices,name,'.$office->id],
        ]);

        $office->update($validated);

        return redirect()->route('admin.offices.index')->with('success', 'Office updated successfully.');
    }

    public function destroy(Office $office): RedirectResponse
    {
        $officeName = $office->name;
        $office->delete();

        return redirect()->route('admin.offices.index')->with('success', "{$officeName} deleted successfully.");
    }
}
