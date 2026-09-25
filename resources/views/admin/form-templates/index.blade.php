@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Admin Module</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">Forms / Templates</h1>
                <p class="mt-2 text-sm text-slate-600">Add and manage existing forms and templates for the public repository.</p>
            </div>

            <form method="GET" class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="md:col-span-2">
                    <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                    <input id="search" name="search" value="{{ request('search') }}" placeholder="Search reference code, title, responsible, or location" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
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
                    <button type="submit" class="rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white">Apply Filters</button>
                    <a href="{{ route('admin.form-templates.index') }}" class="rounded-md border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Reset</a>
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
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Responsible</label>
                    <input name="responsible" value="{{ old('responsible') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
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
                    <input name="document_location" value="{{ old('document_location') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
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
                    <input type="file" name="downloadable_attachment" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white">Save Form / Template</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Reference Code</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Document Type</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Title</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Responsible</th>
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
                                <td class="px-4 py-3">{{ $template->doc_title }}</td>
                                <td class="px-4 py-3">{{ $template->responsible }}</td>
                                <td class="px-4 py-3">{{ $template->revision_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $template->effectivity_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $template->document_location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $template->status->label() }}</td>
                                <td class="px-4 py-3">
                                    @if ($template->downloadable_attachment_path)
                                        <a href="{{ Storage::url($template->downloadable_attachment_path) }}" target="_blank" class="font-semibold text-[#0f3d68]">View file</a>
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
                                <td class="px-4 py-3">{{ $document->draf?->title ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $document->draf?->documentType?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $document->location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $document->status->label() }}</td>
                                <td class="px-4 py-3">
                                    @if ($document->draf?->reference_code)
                                        <form method="POST" action="{{ route('admin.form-templates.import', $document) }}">
                                            @csrf
                                            <button type="submit" class="rounded-md bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white">Import to Repository</button>
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
    </div>
@endsection
