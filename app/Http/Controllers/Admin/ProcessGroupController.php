<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProcessGroupRequest;
use App\Http\Requests\UpdateProcessGroupRequest;
use App\Models\ProcessGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProcessGroupController extends Controller
{
    public function index(): View
    {
        $processGroups = ProcessGroup::query()
            ->with([
                'processes' => fn ($query) => $query
                    ->withCount('subProcesses')
                    ->orderBy('id'),
            ])
            ->withCount('processes')
            ->orderBy('id')
            ->paginate(12);

        return view('admin.operations-manual.index', compact('processGroups'));
    }

    public function create(): View
    {
        return view('admin.operations-manual.process-groups.create');
    }

    public function store(StoreProcessGroupRequest $request): RedirectResponse
    {
        ProcessGroup::query()->create($request->validated());

        return redirect()->route('admin.operations-manual.index')->with('success', 'Process group created.');
    }

    public function edit(ProcessGroup $processGroup): View
    {
        return view('admin.operations-manual.process-groups.edit', compact('processGroup'));
    }

    public function update(UpdateProcessGroupRequest $request, ProcessGroup $processGroup): RedirectResponse
    {
        $processGroup->update($request->validated());

        return redirect()->route('admin.operations-manual.index')->with('success', 'Process group updated.');
    }

    public function destroy(ProcessGroup $processGroup): RedirectResponse
    {
        $processGroup->delete();

        return redirect()->route('admin.operations-manual.index')->with('success', 'Process group deleted. Related processes and sub-processes were also deleted.');
    }
}
