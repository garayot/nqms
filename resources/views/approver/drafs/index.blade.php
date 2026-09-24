@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Approver Queue</h1>
            <p class="mt-2 text-sm text-slate-600">Review recommended DRAFs and approve or disapprove as authorized.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">DRAF</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Requested By</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($drafs as $draf)
                        <tr>
                            <td class="px-4 py-3">{{ $draf->draf_number }}</td>
                            <td class="px-4 py-3">{{ $draf->requestedBy?->name }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$draf->status?->value ?? 'draft'" /></td>
                            <td class="px-4 py-3">
                                <a href="{{ route('approver.drafs.show', $draf) }}" class="rounded-md bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No DRAFs are awaiting approval.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
