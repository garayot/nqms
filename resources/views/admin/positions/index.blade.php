@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Positions</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage official positions used in user profiles and QMS team charts.</p>
                </div>

                <a href="{{ route('admin.positions.create') }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                    + Add Position
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Quick Add</h2>
                <p class="mt-2 text-sm text-slate-600">Create a new position without leaving the listing.</p>
                <div class="mt-6">
                    @include('admin.positions.partials.form')
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-slate-700">Position</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Users</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($positions as $position)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $position->position_name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $position->users_count }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.positions.edit', $position) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">Edit</a>
                                            <form method="POST" action="{{ route('admin.positions.destroy', $position) }}" onsubmit="return confirm('Delete {{ $position->position_name }}? Users assigned to this position will remain, but their position will be cleared.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-slate-500">No positions have been created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection