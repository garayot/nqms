@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Admin Module</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">NQMS Manual</h1>
                    <p class="mt-2 text-sm text-slate-600">Add and manage NQMS Manual documents for the internal repository.</p>
                </div>
            </div>

            <form method="GET" class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="md:col-span-2">
                    <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                    <input id="search" name="search" value="{{ request('search') }}" placeholder="Search reference code, title, originating office, or location" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                        <option value="">All statuses</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3 flex flex-wrap gap-3">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Apply Filters</button>
                    <a href="{{ route('admin.nqms-manuals.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">Add NQMS Manual Document</h2>
            <form method="POST" action="{{ route('admin.nqms-manuals.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Type</label>
                    <select name="document_type_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                        <option value="">Select document type</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}" @selected(old('document_type_id') == $documentType->id)>{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Reference Code</label>
                    <input name="document_reference_code" value="{{ old('document_reference_code') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Doc Title</label>
                    <input name="doc_title" value="{{ old('doc_title') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Originating Office</label>
                    <select name="responsible" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                        <option value="">Select originating office</option>
                        @foreach ($functionalDivisions as $functionalDivision)
                            <option value="{{ $functionalDivision->name }}" @selected(old('responsible') === $functionalDivision->name)>{{ $functionalDivision->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Revision Number</label>
                    <input name="revision_number" value="{{ old('revision_number') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Effectivity Date</label>
                    <input type="date" name="effectivity_date" value="{{ old('effectivity_date') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Location</label>
                    <select name="document_location" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                        <option value="">Select document location</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->name }}" @selected(old('document_location') === $office->name)>{{ $office->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Doc Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                        <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                        <option value="obsolete" @selected(old('status') === 'obsolete')>Obsolete</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Downloadable Attachment URL</label>
                    <input type="url" name="downloadable_attachment_url" value="{{ old('downloadable_attachment_url') }}" placeholder="https://example.com/file.pdf" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Provide a public URL for the manual file.</p>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save NQMS Manual</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-slate-900">Repository List</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Reference Code</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Document Type</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Title</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Originating Office</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Revision</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Effectivity</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Location</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Attachment</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($manuals as $manual)
                            <tr>
                                <td class="px-4 py-3">{{ $manual->document_reference_code }}</td>
                                <td class="px-4 py-3">{{ $manual->documentType?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $manual->doc_title }}</td>
                                <td class="px-4 py-3">{{ $manual->responsible }}</td>
                                <td class="px-4 py-3">{{ $manual->revision_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $manual->effectivity_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $manual->document_location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full {{ $manual->status->value === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} px-2.5 py-1 text-xs font-semibold">
                                        {{ $manual->status->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($manual->downloadable_attachment_url)
                                        <a href="{{ $manual->downloadable_attachment_url }}" target="_blank" class="inline-flex rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-[#0f3d68] hover:bg-slate-50">View file</a>
                                    @else
                                        <span class="text-slate-500">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.nqms-manuals.edit', $manual) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('admin.nqms-manuals.destroy', $manual) }}" onsubmit="return confirm('Delete this NQMS manual entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-8 text-center text-slate-500">No NQMS manual documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $manuals->links() }}
            </div>
        </div>
    </div>
@endsection
