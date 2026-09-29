<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubProcessRequest;
use App\Http\Requests\UpdateSubProcessRequest;
use App\Models\Process;
use App\Models\ProcessGroup;
use App\Models\SubProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubProcessController extends Controller
{
    public function index(ProcessGroup $processGroup, Process $process): View
    {
        $this->ensureProcessBelongsToGroup($processGroup, $process);

        $subProcesses = SubProcess::query()
            ->where('process_id', $process->id)
            ->orderBy('id')
            ->paginate(12);

        return view('admin.operations-manual.sub-processes.index', compact('processGroup', 'process', 'subProcesses'));
    }

    public function create(ProcessGroup $processGroup, Process $process): View
    {
        $this->ensureProcessBelongsToGroup($processGroup, $process);

        return view('admin.operations-manual.sub-processes.create', compact('processGroup', 'process'));
    }

    public function store(StoreSubProcessRequest $request, ProcessGroup $processGroup, Process $process): RedirectResponse
    {
        $this->ensureProcessBelongsToGroup($processGroup, $process);

        SubProcess::query()->create([
            ...$request->validated(),
            'process_id' => $process->id,
        ]);

        return redirect()->route('admin.operations-manual.sub-processes.index', [$processGroup, $process])->with('success', 'Sub-process created.');
    }

    public function edit(ProcessGroup $processGroup, Process $process, SubProcess $subProcess): View
    {
        $this->ensureHierarchy($processGroup, $process, $subProcess);

        return view('admin.operations-manual.sub-processes.edit', compact('processGroup', 'process', 'subProcess'));
    }

    public function update(UpdateSubProcessRequest $request, ProcessGroup $processGroup, Process $process, SubProcess $subProcess): RedirectResponse
    {
        $this->ensureHierarchy($processGroup, $process, $subProcess);

        $subProcess->update([
            ...$request->validated(),
            'process_id' => $process->id,
        ]);

        return redirect()->route('admin.operations-manual.sub-processes.index', [$processGroup, $process])->with('success', 'Sub-process updated.');
    }

    public function destroy(ProcessGroup $processGroup, Process $process, SubProcess $subProcess): RedirectResponse
    {
        $this->ensureHierarchy($processGroup, $process, $subProcess);

        $subProcess->delete();

        return redirect()->route('admin.operations-manual.sub-processes.index', [$processGroup, $process])->with('success', 'Sub-process deleted.');
    }

    private function ensureProcessBelongsToGroup(ProcessGroup $processGroup, Process $process): void
    {
        if ($process->process_group_id !== $processGroup->id) {
            abort(404);
        }
    }

    private function ensureHierarchy(ProcessGroup $processGroup, Process $process, SubProcess $subProcess): void
    {
        $this->ensureProcessBelongsToGroup($processGroup, $process);

        if ($subProcess->process_id !== $process->id) {
            abort(404);
        }
    }
}
