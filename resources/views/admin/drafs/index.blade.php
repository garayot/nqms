@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">DRAF Management</h1>
                <p class="mt-2 text-sm text-slate-600">Monitor, review, and manage all submissions.</p>
            </div>
            <form method="GET" class="w-full max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by draf number or title" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">DRAF</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Title</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Requested By</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($drafs as $draf)
                        <tr>
                            <td class="px-4 py-3">{{ $draf->draf_number }}</td>
                            <td class="px-4 py-3">{{ $draf->title }}</td>
                            <td class="px-4 py-3">{{ $draf->requestedBy?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$draf->status?->value ?? 'draft'" /></td>
                            <td class="px-4 py-3"><a href="{{ route('admin.drafs.show', $draf) }}" class="font-semibold text-[#0f3d68]">Review</a></td>
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
    </div>
@endsection
