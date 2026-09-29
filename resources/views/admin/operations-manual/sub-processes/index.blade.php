@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">
                <a href="{{ route('admin.operations-manual.index') }}" class="hover:text-[#0f3d68]">Operations Manual</a>
                <span class="mx-2">&gt;</span>
                <a href="{{ route('admin.operations-manual.processes.index', $processGroup) }}" class="hover:text-[#0f3d68]">{{ $processGroup->process_group_name }}</a>
                <span class="mx-2">&gt;</span>
                <span>{{ $process->process_name }}</span>
            </div>

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $process->process_name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage sub-processes and optional QCP links.</p>
                </div>
                <a href="{{ route('admin.operations-manual.sub-processes.create', [$processGroup, $process]) }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Sub-Process</a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Sub-Processes</h2>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Sub-Process</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">QCP Link</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($subProcesses as $subProcess)
                            <tr>
                                <td class="px-4 py-3">{{ $subProcess->sub_process_name }}</td>
                                <td class="px-4 py-3">
                                    @if ($subProcess->url)
                                        <a href="{{ $subProcess->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Open QCP</a>
                                    @else
                                        <span class="text-slate-500">No QCP Link</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.operations-manual.sub-processes.edit', [$processGroup, $process, $subProcess]) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.operations-manual.sub-processes.destroy', [$processGroup, $process, $subProcess]) }}" onsubmit="return confirm('Delete this sub-process?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-500">No sub-processes found for this process.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $subProcesses->links() }}
            </div>
        </div>
    </div>
@endsection
