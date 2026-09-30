@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Operations Manual</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage process groups for the operations manual hierarchy.</p>
                </div>
                <a href="{{ route('admin.operations-manual.process-groups.create') }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Process Group</a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Process Groups</h2>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Name</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">URL</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Processes</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($processGroups as $processGroup)
                            <tr>
                                <td class="px-4 py-3">{{ $processGroup->process_group_name }}</td>
                                <td class="px-4 py-3">
                                    @if ($processGroup->url)
                                        <a href="{{ $processGroup->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">Open Link</a>
                                    @else
                                        <span class="inline-flex rounded-md bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">No Link</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $processGroup->processes_count }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.operations-manual.processes.index', $processGroup) }}" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">View</a>
                                        <a href="{{ route('admin.operations-manual.process-groups.edit', $processGroup) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.operations-manual.process-groups.destroy', $processGroup) }}" onsubmit="return confirm('Delete this process group? All related processes and sub-processes will also be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No process groups found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $processGroups->links() }}
            </div>
        </div>
    </div>
@endsection
