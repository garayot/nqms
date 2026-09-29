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

        <form method="GET" class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_280px]">
                <div>
                    <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Reference Code, Title, Responsible, Location..." class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none ring-0 focus:border-[#0f3d68] focus:bg-white">
                    </div>
                </div>

                <div>
                    <label for="document_type_id" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Type</label>
                    <select id="document_type_id" name="document_type_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                        <option value="">All document types</option>
                        @foreach ($documentTypeOptions as $value => $label)
                            <option value="{{ $value }}" @selected((string) request('document_type_id') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</span>
                    <button type="submit" name="status" value="" class="rounded-full border px-3 py-1 text-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#0f3d68] hover:bg-[#0f3d68]/10 hover:text-[#0f3d68] {{ request('status') === null || request('status') === '' ? 'border-[#0f3d68] bg-[#0f3d68]/10 text-[#0f3d68]' : 'border-slate-300 text-slate-600' }}">All</button>
                    @foreach ($statusOptions as $value => $label)
                        <button type="submit" name="status" value="{{ $value }}" class="rounded-full border px-3 py-1 text-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#0f3d68] hover:bg-[#0f3d68]/10 hover:text-[#0f3d68] {{ request('status') === $value ? 'border-[#0f3d68] bg-[#0f3d68]/10 text-[#0f3d68]' : 'border-slate-300 text-slate-600' }}">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                    <a href="{{ url()->current() }}" class="inline-flex items-center gap-1 rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M3 2v6h6"/><path d="M21 12A9 9 0 0 0 6 5.3L3 8"/><path d="M21 22v-6h-6"/><path d="M3 12a9 9 0 0 0 15 6.7l3-2.7"/></svg>
                        Reset
                    </a>
                    <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Apply filters
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
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
                        <th class="px-4 py-3 text-center font-bold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800">
                    @forelse ($documents as $document)
                        <tr class="align-top">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $document->document_reference_code }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-900">{{ $document->doc_title }}</div>
                                <!-- <div class="mt-1 inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ $document->status->label() }}</div> -->
                            </td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">{{ $document->responsible }}</td>
                            <td class="px-4 py-3 text-center font-semibold">{{ $document->revision_number ?? 'N/A' }}</td>
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
                                        <a href="{{ $attachmentLink }}" target="_blank" aria-label="Download" class="inline-flex rounded-md bg-[#0f3d68] p-2 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download preview-icon h-4 w-4"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                                        </a>
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
