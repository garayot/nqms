@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Settings</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Reasons</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage reason options used in DRAF requests.</p>
                </div>

                <a href="{{ route('admin.reasons.create') }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                    + Add Reason
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Quick Add</h2>
                <p class="mt-2 text-sm text-slate-600">Create a reason without leaving the listing.</p>
                <div class="mt-6">
                    <form method="POST" action="{{ route('admin.reasons.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Reason</label>
                            <input id="name" name="name" value="{{ old('name') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-slate-700">Reason</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">DRAFs</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($reasons as $reason)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $reason->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $reason->drafs_count }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.reasons.edit', $reason) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">Edit</a>
                                            <form method="POST" action="{{ route('admin.reasons.destroy', $reason) }}" onsubmit="return confirm('Delete {{ $reason->name }}? DRAFs using this reason will keep the request but clear this reason selection.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-500">No reasons have been created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
