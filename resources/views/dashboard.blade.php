@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
        <p class="mt-2 text-sm text-slate-600">Welcome back, {{ auth()->user()->name }}.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $key => $value)
            @php
                $label = str_replace('_', ' ', $key);
                $label = ucwords($label);
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $label }}</div>
                <div class="mt-3 text-3xl font-bold text-slate-900">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-slate-900">Recent DRAFs</h2>
            <a href="{{ route('draf.index') }}" class="text-sm font-semibold text-[#0f3d68]">View all</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead>
                    <tr class="text-slate-600">
                        <th class="px-3 py-2 font-semibold">DRAF Number</th>
                        <th class="px-3 py-2 font-semibold">Title</th>
                        <th class="px-3 py-2 font-semibold">Status</th>
                        <th class="px-3 py-2 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($drafs as $draf)
                        <tr>
                            <td class="px-3 py-3">{{ $draf->draf_number }}</td>
                            <td class="px-3 py-3">{{ $draf->title }}</td>
                            <td class="px-3 py-3"><x-status-badge :status="$draf->status?->value ?? 'draft'" /></td>
                            <td class="px-3 py-3"><a href="{{ route('draf.show', $draf) }}" class="font-semibold text-[#0f3d68]">Open</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-6 text-center text-slate-500">No DRAFs available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
