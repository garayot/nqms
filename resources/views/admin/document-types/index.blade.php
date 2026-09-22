@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Document Types</h1>
            <p class="mt-2 text-sm text-slate-600">Add and manage document classifications used by the NQMS workflow.</p>

            <form method="POST" action="{{ route('admin.document-types.store') }}" class="mt-6 grid gap-4 md:grid-cols-3">
                @csrf
                <input name="name" placeholder="Document type name" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                <input name="description" placeholder="Description" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white">Add Type</button>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Name</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Description</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($types as $type)
                            <tr>
                                <td class="px-4 py-3">{{ $type->name }}</td>
                                <td class="px-4 py-3">{{ $type->description ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $type->is_active ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-500">No document types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
