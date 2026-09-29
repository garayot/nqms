@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Public Repository</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">Forms and Templates</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Browse active forms and templates uploaded by administrators.</p>
            </div>
        </div>

        <form method="GET" class="mb-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="xl:col-span-2">
                    <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Search title, reference code, responsible, or location" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                </div>

                <div>
                    <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-3 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                        <option value="">All statuses</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">Apply Filters</button>
                <a href="{{ url()->current() }}" class="inline-flex rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Reset</a>
            </div>
        </form>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Document Reference Code</th>
                        <th class="px-4 py-3 font-semibold">Document Title/Description</th>
                        <th class="px-4 py-3 font-semibold">Originating Office</th>
                        <th class="px-4 py-3 font-semibold">Person Responsible</th>
                        <th class="px-4 py-3 font-semibold">Revision Number</th>
                        <th class="px-4 py-3 font-semibold">Effectivity Date</th>
                        <th class="px-4 py-3 font-semibold">Location</th>
                        <th class="px-4 py-3 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800">
                    @forelse ($documents as $document)
                        <tr class="align-top">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $document->document_reference_code }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-900">{{ $document->doc_title }}</div>
                                <div class="mt-1 inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ $document->status->label() }}</div>
                            </td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">{{ $document->responsible }}</td>
                            <td class="px-4 py-3">{{ $document->revision_number ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $document->effectivity_date?->format('F d, Y') ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $document->document_location ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end">
                                    @if ($document->downloadable_attachment_path)
                                        @php
                                            $attachmentLink = \Illuminate\Support\Str::startsWith($document->downloadable_attachment_path, ['http://', 'https://'])
                                                ? $document->downloadable_attachment_path
                                                : Storage::url($document->downloadable_attachment_path);
                                        @endphp
                                        <a href="{{ $attachmentLink }}" target="_blank" class="inline-flex rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white">Download</a>
                                    @else
                                        <span class="text-xs text-slate-500">No file</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-500">No forms or templates are currently available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
