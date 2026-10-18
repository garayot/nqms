<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReasonController extends Controller
{
    public function index(): View
    {
        $reasons = Reason::query()
            ->withCount('drafs')
            ->orderBy('name')
            ->get();

        return view('admin.reasons.index', compact('reasons'));
    }

    public function create(): View
    {
        return view('admin.reasons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:reasons,name'],
        ]);

        $reason = Reason::create($validated);

        return redirect()->route('admin.reasons.index')->with('success', "{$reason->name} created successfully.");
    }

    public function edit(Reason $reason): View
    {
        return view('admin.reasons.edit', compact('reason'));
    }

    public function update(Request $request, Reason $reason): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:reasons,name,'.$reason->id],
        ]);

        $reason->update($validated);

        return redirect()->route('admin.reasons.index')->with('success', 'Reason updated successfully.');
    }

    public function destroy(Reason $reason): RedirectResponse
    {
        $reasonName = $reason->name;
        $reason->delete();

        return redirect()->route('admin.reasons.index')->with('success', "{$reasonName} deleted successfully.");
    }
}
