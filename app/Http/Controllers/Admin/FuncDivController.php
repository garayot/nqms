<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuncDiv;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FuncDivController extends Controller
{
    public function index(): View
    {
        $funcDivs = FuncDiv::query()
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return view('admin.func-divs.index', compact('funcDivs'));
    }

    public function create(): View
    {
        return view('admin.func-divs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:func_div,name'],
        ]);

        $funcDiv = FuncDiv::create($validated);

        return redirect()->route('admin.func-divs.index')->with('success', "{$funcDiv->name} created successfully.");
    }

    public function edit(FuncDiv $funcDiv): View
    {
        return view('admin.func-divs.edit', compact('funcDiv'));
    }

    public function update(Request $request, FuncDiv $funcDiv): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:func_div,name,'.$funcDiv->id],
        ]);

        $funcDiv->update($validated);

        return redirect()->route('admin.func-divs.index')->with('success', 'Functional division updated successfully.');
    }

    public function destroy(FuncDiv $funcDiv): RedirectResponse
    {
        $funcDivName = $funcDiv->name;
        $funcDiv->delete();

        return redirect()->route('admin.func-divs.index')->with('success', "{$funcDivName} deleted successfully.");
    }
}
