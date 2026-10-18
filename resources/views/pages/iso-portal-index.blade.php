@extends('layouts.guest')

@section('content')
    @php
        $isRoot = blank($folder);
        $isDivisionLevel = $folder === 'osd' && blank($office);
        $isDocumentLevel = filled($division) && filled($office);
        $divisionFolderClass = 'flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 transition hover:border-slate-300 hover:bg-slate-50';
        $activeFolderClass = 'flex items-center justify-between gap-3 rounded-xl border border-[#0f3d68] bg-[#0f3d68]/5 px-3 py-2.5 text-sm font-semibold text-[#0f3d68]';
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Public Repository</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">ISO Portal</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-600">Browse folders for each functional division and office, then open the document list for downloadable forms and templates.</p>
            </div>

            <form method="GET" class="w-full lg:max-w-xl">
                <input type="hidden" name="folder" value="{{ $folder ?: 'osd' }}">
                @if (filled($division))
                    <input type="hidden" name="division" value="{{ $division }}">
                @endif
                @if (filled($office))
                    <input type="hidden" name="office" value="{{ $office }}">
                @endif
                <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Search</label>
                <div class="flex gap-2">
                    <input id="search" type="text" name="search" value="{{ $search }}" placeholder="Search reference code, title, division, office..." class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none ring-0 focus:border-[#0f3d68]">
                    <button type="submit" class="inline-flex shrink-0 items-center rounded-xl bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Search</button>
                </div>
            </form>
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,320px)_minmax(0,1fr)]">
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Folder Directory</h2>
                            <p class="mt-1 text-sm text-slate-600">Click folders to drill down into the repository.</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <a href="{{ route('iso-portal.index', ['folder' => 'osd', 'search' => $search]) }}" class="flex items-center justify-between gap-3 rounded-2xl border px-4 py-3 transition {{ $folder === 'osd' ? 'border-[#0f3d68] bg-[#0f3d68]/5 text-[#0f3d68]' : 'border-slate-200 bg-slate-50 text-slate-900 hover:border-slate-300 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-3 font-semibold">
                                <span class="text-xl">📁</span>
                                <span>OSD</span>
                            </span>
                            <span class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-slate-500 ring-1 ring-slate-200">Root</span>
                        </a>

                        @if ($folder === 'osd')
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Subfolders</p>
                                        <h3 class="mt-1 text-sm font-semibold text-slate-900">Functional Divisions</h3>
                                    </div>
                                    @if (filled($division))
                                        <a href="{{ route('iso-portal.index', ['folder' => 'osd', 'search' => $search]) }}" class="text-xs font-semibold text-[#0f3d68] hover:underline">Clear</a>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    @forelse ($availableDivisions as $availableDivision)
                                        @php
                                            $divisionFileCount = (int) ($divisionCounts[$availableDivision] ?? 0);
                                        @endphp
                                        <a href="{{ route('iso-portal.index', ['folder' => 'osd', 'division' => $availableDivision, 'search' => $search]) }}" class="{{ $division === $availableDivision ? $activeFolderClass : $divisionFolderClass }}">
                                            <span class="flex items-center gap-3">
                                                <span class="text-lg">📁</span>
                                                <span>{{ $availableDivision }}</span>
                                            </span>
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $divisionFileCount }}</span>
                                        </a>
                                    @empty
                                        <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500">No functional divisions found.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        @if (filled($division))
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Subfolders</p>
                                        <h3 class="mt-1 text-sm font-semibold text-slate-900">Office Folders</h3>
                                    </div>
                                    @if (filled($office))
                                        <a href="{{ route('iso-portal.index', ['folder' => 'osd', 'division' => $division, 'search' => $search]) }}" class="text-xs font-semibold text-[#0f3d68] hover:underline">Clear</a>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    @forelse ($officeFolders as $officeFolder)
                                        @php
                                            $officeFileCount = (int) ($officeCounts[$officeFolder] ?? 0);
                                        @endphp
                                        <a href="{{ route('iso-portal.index', ['folder' => 'osd', 'division' => $division, 'office' => $officeFolder, 'search' => $search]) }}" class="{{ $office === $officeFolder ? $activeFolderClass : $divisionFolderClass }}">
                                            <span class="flex items-center gap-3">
                                                <span class="text-lg">📄</span>
                                                <span>{{ $officeFolder }}</span>
                                            </span>
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $officeFileCount }}</span>
                                        </a>
                                    @empty
                                        <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-3 text-sm text-slate-500">No office folders found in this division.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Document List</h2>
                            <p class="mt-1 text-sm text-slate-600">
                                @if (filled($office))
                                    Documents in {{ $division }} &rsaquo; {{ $office }}
                                @elseif (filled($division))
                                    Select an office subfolder to view documents.
                                @else
                                    Select OSD, then a functional division and office folder to view documents.
                                @endif
                            </p>
                        </div>

                        @if (filled($division))
                            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Folder: OSD</span>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Division: {{ $division }}</span>
                                @if (filled($office))
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Office: {{ $office }}</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200">
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
                                @forelse ($documents as $document)
                                    <tr class="align-top">
                                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $document->document_reference_code }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-slate-900">{{ $document->doc_title }}</div>
                                        </td>
                                        <td class="px-4 py-3">{{ $document->responsible }}</td>
                                        <td class="px-4 py-3">{{ $document->uploader?->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center font-semibold">{{ $document->revision_number ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $document->effectivity_date?->format('F d, Y') ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $document->document_location ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusValue = $document->status instanceof \BackedEnum ? $document->status->value : (string) $document->status;
                                                $statusLabel = $document->status instanceof \BackedEnum ? $document->status->label() : ucfirst($statusValue);
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
                                                @if ($document->downloadable_attachment_path)
                                                    <a href="{{ route('public.file-access.form-templates', $document) }}" class="inline-flex items-center gap-2 rounded-md bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white">
                                                        @auth
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                                                            <span>Download</span>
                                                        @else
                                                            <span>Login to download</span>
                                                        @endauth
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

                    <div class="mt-6">
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
