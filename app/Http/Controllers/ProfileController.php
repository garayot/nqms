<?php

namespace App\Http\Controllers;

use App\Models\FuncDiv;
use App\Models\Office;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $offices = Office::query()
            ->orderBy('name')
            ->get();

        $functionalDivs = FuncDiv::query()
            ->orderBy('name')
            ->get();

        $positions = Position::query()
            ->orderBy('position_name')
            ->get();

        return view('profile.edit', compact('offices', 'functionalDivs', 'positions'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'office_id' => ['nullable', 'exists:offices,id'],
            'functional_div_id' => ['nullable', 'exists:func_div,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
        ]);

        $office = filled($validated['office_id'] ?? null)
            ? Office::query()->find($validated['office_id'])
            : null;

        $request->user()->update([
            'office_id' => $validated['office_id'] ?? null,
            'functional_div_id' => $validated['functional_div_id'] ?? null,
            'position_id' => $validated['position_id'] ?? null,
            'office' => $office?->name,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
