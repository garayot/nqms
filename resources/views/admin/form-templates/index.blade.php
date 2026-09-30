@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Admin Module</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Forms / Templates</h1>
                    <p class="mt-2 text-sm text-slate-600">Add and manage existing forms and templates for the public repository.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.form-templates.csv-template') }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Download CSV Template
                    </a>
                    <button type="button" onclick="document.getElementById('csv-import-dialog').showModal()" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Upload CSV
                    </button>
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
                    <a href="{{ route('admin.form-templates.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">Add Form / Template</h2>
            <form method="POST" action="{{ route('admin.form-templates.store') }}" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-2">
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
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Downloadable Attachment</label>
                    <input type="file" name="downloadable_attachment" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Upload a file or provide a URL below.</p>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Downloadable Attachment URL</label>
                    <input type="url" name="downloadable_attachment_url" value="{{ old('downloadable_attachment_url') }}" placeholder="https://example.com/file.pdf" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save Form / Template</button>
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($templates as $template)
                            <tr>
                                <td class="px-4 py-3">{{ $template->document_reference_code }}</td>
                                <td class="px-4 py-3">{{ $template->documentType?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $template->doc_title }}</span>
                                        @if (in_array($template->document_reference_code, $importedReferenceCodes, true))
                                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.15em] text-emerald-700">Imported</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $template->responsible }}</td>
                                <td class="px-4 py-3">{{ $template->revision_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $template->effectivity_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $template->document_location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full {{ $template->status->value === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} px-2.5 py-1 text-xs font-semibold">
                                        {{ $template->status->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($template->downloadable_attachment_path)
                                        @php
                                            $attachmentLink = \Illuminate\Support\Str::startsWith($template->downloadable_attachment_path, ['http://', 'https://'])
                                                ? $template->downloadable_attachment_path
                                                : Storage::url($template->downloadable_attachment_path);
                                        @endphp
                                        <a href="{{ $attachmentLink }}" target="_blank" class="inline-flex rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-[#0f3d68] hover:bg-slate-50">View file</a>
                                    @else
                                        <span class="text-slate-500">None</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-slate-500">No forms or templates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $templates->links() }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Registered Documents</h2>
                    <p class="mt-1 text-sm text-slate-600">Use these entries to add existing registered forms/templates to the repository.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Reference Code</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Title</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Type</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Location</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($registeredDocuments as $document)
                            <tr>
                                <td class="px-4 py-3">{{ $document->draf?->reference_code ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $document->draf?->title ?? 'N/A' }}</span>
                                        @if (in_array($document->draf?->reference_code, $importedReferenceCodes, true))
                                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.15em] text-emerald-700">Imported</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $document->draf?->documentType?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $document->location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full {{ $document->status->value === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} px-2.5 py-1 text-xs font-semibold">
                                        {{ $document->status->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if (in_array($document->draf?->reference_code, $importedReferenceCodes, true))
                                        <span class="inline-flex rounded-lg bg-emerald-100 px-3 py-2 text-xs font-semibold text-emerald-700">Already imported</span>
                                    @elseif ($document->draf?->reference_code)
                                        <form method="POST" action="{{ route('admin.form-templates.import', $document) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white hover:bg-[#0b2f52]">Import to Repository</button>
                                        </form>
                                    @else
                                        <span class="text-slate-500">Unavailable</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">No registered documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $registeredDocuments->links() }}
            </div>
        </div>

        <dialog id="csv-import-dialog" class="w-full max-w-lg rounded-2xl border border-slate-200 p-0 shadow-xl backdrop:bg-slate-900/40">
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h3 class="text-xl font-semibold text-slate-900">Upload CSV for Bulk Import</h3>
                    <button type="button" onclick="document.getElementById('csv-import-dialog').close()" class="rounded-md border border-slate-300 px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Close</button>
                </div>

                <p class="mb-2 text-sm text-slate-600">Required columns: document_type or document_type_id, document_reference_code, doc_title, originating_office.</p>
                <p class="mb-4 text-xs text-slate-500">Download the CSV template above to get the exact header format and sample values.</p>

                <form method="POST" action="{{ route('admin.form-templates.import-csv') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">CSV File</label>
                        <input type="file" name="csv_file" accept=".csv,text/csv" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" onclick="document.getElementById('csv-import-dialog').close()" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Import</button>
                    </div>
                </form>
            </div>
        </dialog>
    </div>
@endsection
