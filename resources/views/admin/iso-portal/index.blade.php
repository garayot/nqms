@extends('layouts.app')

@section('content')
    @php
        $selectedDivision = request('division');
        $selectedOffice = request('office');
        $activeFolderClass = 'rounded-lg border border-[#0f3d68] bg-[#0f3d68]/5 px-3 py-2 text-sm font-semibold text-[#0f3d68]';
        $folderClass = 'rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition hover:border-slate-300 hover:bg-slate-50';
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Admin Module</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">ISO Portal Management</h1>
                    <p class="mt-2 max-w-3xl text-sm text-slate-600">Organize approved Forms/Template documents by functional division and office folders, and manage downloadable repository entries for logged-in users.</p>
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

            <form method="GET" class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="md:col-span-2 xl:col-span-2">
                    <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Reference code, title, division, office, person responsible..." class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none ring-0 focus:border-[#0f3d68] focus:bg-white">
                    </div>
                </div>

                <div>
                    <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</label>
                    <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                        <option value="">All statuses</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected((string) request('status') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="document_type" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Type</label>
                    <select id="document_type" name="document_type_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                        <option value="">All document types</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}" @selected((string) request('document_type_id') === (string) $documentType->id)>{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 xl:col-span-4 flex flex-wrap items-center gap-2">
                    <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">
                        Apply filters
                    </button>
                    <a href="{{ route('admin.iso-portal.index') }}" class="inline-flex items-center gap-1 rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,320px)_minmax(0,1fr)]">
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Folder Directory</h2>
                            <p class="mt-1 text-sm text-slate-600">Browse repository folders by functional division and office.</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse ($folderDivisions as $division)
                            @php
                                $divisionTotal = collect($folderTotals[$division->name] ?? [])->sum();
                            @endphp

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <a href="{{ route('admin.iso-portal.index', ['division' => $division->name, 'status' => request('status'), 'document_type_id' => request('document_type_id'), 'search' => request('search')]) }}" class="inline-flex items-center gap-2 font-semibold text-slate-900 hover:text-[#0f3d68]">
                                        <span class="text-base">📁</span>
                                        <span>{{ $division->name }}</span>
                                    </a>
                                    <span class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">{{ $divisionTotal }} files</span>
                                </div>

                                <div class="mt-3 space-y-2 pl-6">
                                    @forelse ($offices as $office)
                                        @php
                                            $fileCount = $folderTotals[$division->name][$office->name] ?? 0;
                                        @endphp

                                        <a href="{{ route('admin.iso-portal.index', ['division' => $division->name, 'office' => $office->name, 'status' => request('status'), 'document_type_id' => request('document_type_id'), 'search' => request('search')]) }}" class="flex items-center justify-between gap-3 {{ $selectedDivision === $division->name && $selectedOffice === $office->name ? $activeFolderClass : $folderClass }}">
                                            <span class="flex items-center gap-2">
                                                <span class="text-slate-400">📄</span>
                                                <span>{{ $office->name }}</span>
                                            </span>
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $fileCount }}</span>
                                        </a>
                                    @empty
                                        <div class="text-sm text-slate-500">No offices found.</div>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                                No functional divisions found.
                            </div>
                        @endforelse
                    </div>
                </div>

                
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Add Form / Template</h2>
                    <p class="mt-1 text-sm text-slate-600">Save a form/template directly into a selected folder.</p>

                    <form method="POST" action="{{ route('admin.form-templates.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
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
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Functional Division Folder</label>
                            <select name="responsible" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                                <option value="">Select functional division</option>
                                @foreach ($functionalDivisions as $functionalDivision)
                                    <option value="{{ $functionalDivision->name }}" @selected(old('responsible', $selectedDivision) === $functionalDivision->name)>{{ $functionalDivision->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Person Responsible</label>
                            <input value="{{ auth()->user()?->name ?? 'N/A' }}" class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2.5 text-sm text-slate-700" disabled>
                            <p class="mt-1 text-xs text-slate-500">Automatically set to the uploader when saved.</p>
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
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Office Subfolder</label>
                            <select name="document_location" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                                <option value="">Select office</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->name }}" @selected(old('document_location', $selectedOffice) === $office->name)>{{ $office->name }}</option>
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
                            <p class="mt-1 text-xs text-slate-500">Provide a public URL for the form/template file.</p>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save Form / Template</button>
                        </div>
                    </form>
                </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Repository List</h2>
                            <p class="mt-1 text-sm text-slate-600">A searchable list of forms and templates arranged by folder context.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-center font-bold">Document Reference Code</th>
                                    <th class="px-4 py-3 text-center font-bold">Document Title/Description</th>
                                    <th class="px-4 py-3 text-center font-bold">Originating Office</th>
                                    <th class="px-4 py-3 text-center font-bold">Person Responsible</th>
                                    <th class="px-4 py-3 text-center font-bold">Revision Number</th>
                                    <th class="px-4 py-3 text-center font-bold">Effectivity Date</th>
                                    <th class="px-4 py-3 text-center font-bold">Location</th>
                                    <th class="px-4 py-3 text-center font-bold">Status</th>
                                    <th class="px-4 py-3 text-center font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 text-slate-800">
                                @forelse ($templates as $template)
                                    <tr class="align-top">
                                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $template->document_reference_code }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-slate-900">{{ $template->doc_title }}</div>
                                        </td>
                                        <td class="px-4 py-3">{{ $template->responsible }}</td>
                                        <td class="px-4 py-3">{{ $template->uploader?->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center font-semibold">{{ $template->revision_number ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $template->effectivity_date?->format('F d, Y') ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $template->document_location ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusValue = $template->status instanceof \BackedEnum ? $template->status->value : (string) $template->status;
                                                $statusLabel = $template->status instanceof \BackedEnum ? $template->status->label() : ucfirst($statusValue);
                                                $statusClasses = $statusValue === 'active'
                                                    ? 'bg-blue-100 text-blue-700 ring-blue-200'
                                                    : 'bg-amber-100 text-amber-700 ring-amber-200';
                                            @endphp

                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClasses }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex justify-end">
                                                @if ($template->downloadable_attachment_path)
                                                    @php
                                                        $attachmentLink = \Illuminate\Support\Str::startsWith($template->downloadable_attachment_path, ['http://', 'https://'])
                                                            ? $template->downloadable_attachment_path
                                                            : Storage::url($template->downloadable_attachment_path);
                                                    @endphp
                                                    <a href="{{ $attachmentLink }}" target="_blank" class="inline-flex items-center gap-2 rounded-md bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white">
                                                        View file
                                                    </a>
                                                @else
                                                    <span class="text-xs text-slate-500">No file</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-slate-500">No forms or templates are currently available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
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
                                            <div class="flex items-center gap-2">
                                                @if (! $document->draf)
                                                    <span class="text-slate-500">Unavailable</span>
                                                @elseif ($document->draf?->reference_code)
                                                    <a href="{{ route('admin.drafs.edit', $document->draf) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit DRAF</a>
                                                @else
                                                    <a href="{{ route('admin.drafs.edit', $document->draf) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Add Details</a>
                                                @endif
                                                @if ($document->draf && in_array($document->draf?->reference_code, $importedReferenceCodes, true))
                                                    <span class="inline-flex rounded-lg bg-emerald-100 px-3 py-2 text-xs font-semibold text-emerald-700">Already imported</span>
                                                @elseif ($document->draf?->reference_code)
                                                    <form method="POST" action="{{ route('admin.form-templates.import', $document) }}">
                                                        @csrf
                                                        <button type="submit" class="rounded-lg bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white hover:bg-[#0b2f52]">Import to Repository</button>
                                                    </form>
                                                @endif
                                            </div>
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
