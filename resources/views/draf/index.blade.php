@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">My DRAFs</h1>
            <p class="mt-2 text-sm text-slate-600">Track document requests, reviews, and status updates.</p>
        </div>
        <a href="{{ route('draf.create') }}" class="rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">Create DRAF</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 font-semibold text-slate-700">DRAF Number</th>
                    <th class="px-4 py-3 font-semibold text-slate-700">Title</th>
                    <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-700">Requested</th>
                    <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($drafs as $draf)
                    <tr>
                        <td class="px-4 py-3">{{ $draf->draf_number }}</td>
                        <td class="px-4 py-3">{{ $draf->title }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$draf->status?->value ?? 'draft'" /></td>
                        <td class="px-4 py-3">{{ $draf->date_requested ? $draf->date_requested->format('M d, Y') : '—' }}</td>
                        <td class="px-4 py-3"><a href="{{ route('draf.show', $draf) }}" class="font-semibold text-[#0f3d68]">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">No DRAFs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $drafs->links() }}
    </div>
@endsection
