@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">
                <a href="{{ route('admin.operations-manual.index') }}" class="hover:text-[#0f3d68]">Operations Manual</a>
                <span class="mx-2">&gt;</span>
                <span>{{ $processGroup->process_group_name }}</span>
            </div>

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $processGroup->process_group_name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage processes under this process group.</p>
                </div>
                <a href="{{ route('admin.operations-manual.processes.create', $processGroup) }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Process</a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Processes</h2>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Process Name</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Sub-Processes</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($processes as $process)
                            <tr>
                                <td class="px-4 py-3">{{ $process->process_name }}</td>
                                <td class="px-4 py-3">{{ $process->sub_processes_count }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.operations-manual.sub-processes.index', [$processGroup, $process]) }}" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">Manage</a>
                                        <a href="{{ route('admin.operations-manual.processes.edit', [$processGroup, $process]) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.operations-manual.processes.destroy', [$processGroup, $process]) }}" onsubmit="return confirm('Delete this process? All related sub-processes will also be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-500">No processes found for this process group.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $processes->links() }}
            </div>
        </div>
    </div>
@endsection
