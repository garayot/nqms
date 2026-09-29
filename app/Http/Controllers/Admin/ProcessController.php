<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProcessRequest;
use App\Http\Requests\UpdateProcessRequest;
use App\Models\Process;
use App\Models\ProcessGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProcessController extends Controller
{
    public function index(ProcessGroup $processGroup): View
    {
        $processes = Process::query()
            ->where('process_group_id', $processGroup->id)
            ->withCount('subProcesses')
            ->orderBy('id')
            ->paginate(12);

        return view('admin.operations-manual.processes.index', compact('processGroup', 'processes'));
    }

    public function create(ProcessGroup $processGroup): View
    {
        return view('admin.operations-manual.processes.create', compact('processGroup'));
    }

    public function store(StoreProcessRequest $request, ProcessGroup $processGroup): RedirectResponse
    {
        Process::query()->create([
            ...$request->validated(),
            'process_group_id' => $processGroup->id,
        ]);

        return redirect()->route('admin.operations-manual.processes.index', $processGroup)->with('success', 'Process created.');
    }

    public function edit(ProcessGroup $processGroup, Process $process): View
    {
        $this->ensureBelongsToGroup($processGroup, $process);

        return view('admin.operations-manual.processes.edit', compact('processGroup', 'process'));
    }

    public function update(UpdateProcessRequest $request, ProcessGroup $processGroup, Process $process): RedirectResponse
    {
        $this->ensureBelongsToGroup($processGroup, $process);

        $process->update([
            ...$request->validated(),
            'process_group_id' => $processGroup->id,
        ]);

        return redirect()->route('admin.operations-manual.processes.index', $processGroup)->with('success', 'Process updated.');
    }

    public function destroy(ProcessGroup $processGroup, Process $process): RedirectResponse
    {
        $this->ensureBelongsToGroup($processGroup, $process);

        $process->delete();

        return redirect()->route('admin.operations-manual.processes.index', $processGroup)->with('success', 'Process deleted. Related sub-processes were also deleted.');
    }

    private function ensureBelongsToGroup(ProcessGroup $processGroup, Process $process): void
    {
        if ($process->process_group_id !== $processGroup->id) {
            abort(404);
        }
    }
}
