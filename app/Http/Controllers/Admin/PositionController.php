<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{
    public function index(): View
    {
        $positions = Position::query()
            ->withCount('users')
            ->orderBy('position_name')
            ->get();

        return view('admin.positions.index', compact('positions'));
    }

    public function create(): View
    {
        return view('admin.positions.create');
    }

    public function store(StorePositionRequest $request): RedirectResponse
    {
        $position = Position::create($request->validated());

        return redirect()->route('admin.positions.index')->with('success', "{$position->position_name} created successfully.");
    }

    public function edit(Position $position): View
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(UpdatePositionRequest $request, Position $position): RedirectResponse
    {
        $position->update($request->validated());

        return redirect()->route('admin.positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position): RedirectResponse
    {
        $positionName = $position->position_name;
        $position->delete();

        return redirect()->route('admin.positions.index')->with('success', "{$positionName} deleted successfully.");
    }
}
