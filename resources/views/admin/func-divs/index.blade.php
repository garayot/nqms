@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Functional Divisions</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage origin functional divisions used by users.</p>
                </div>

                <a href="{{ route('admin.func-divs.create') }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                    + Add Functional Division
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Quick Add</h2>
                <p class="mt-2 text-sm text-slate-600">Create a new functional division without leaving the listing.</p>
                <div class="mt-6">
                    <form method="POST" action="{{ route('admin.func-divs.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Functional Division Name</label>
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
                                <th class="px-4 py-3 font-semibold text-slate-700">Functional Division</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Users</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($funcDivs as $funcDiv)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $funcDiv->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $funcDiv->users_count }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.func-divs.edit', $funcDiv) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">Edit</a>
                                            <form method="POST" action="{{ route('admin.func-divs.destroy', $funcDiv) }}" onsubmit="return confirm('Delete {{ $funcDiv->name }}? Users assigned to this division will remain, but their division reference will be cleared.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-500">No functional divisions have been created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
