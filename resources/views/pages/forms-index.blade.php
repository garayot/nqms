@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Public Repository</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">Forms and Templates</h1>
            </div>
            <form method="GET" class="w-full max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or reference code" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none ring-0 focus:border-[#0f3d68]">
            </form>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($documents as $document)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ $document->status->label() }}</span>
                        <span class="text-xs text-slate-500">Rev. {{ $document->draf->current_revision_no ?? 'N/A' }}</span>
                    </div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ $document->draf->title }}</h2>
                    <dl class="mt-4 space-y-2 text-sm text-slate-600">
                        <div class="flex justify-between gap-4"><dt>Reference Code</dt><dd>{{ $document->draf->reference_code ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Type</dt><dd>{{ $document->draf->documentType?->name ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Applicability</dt><dd>{{ $document->draf->applicability?->label() ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Office</dt><dd>{{ $document->originatingOffice?->office ?? 'N/A' }}</dd></div>
                    </dl>
                    <div class="mt-5">
                        @if ($document->downloadable_doc_path)
                            <a href="{{ Storage::url($document->downloadable_doc_path) }}" target="_blank" class="inline-flex rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">Download</a>
                        @else
                            <span class="text-sm text-slate-500">No downloadable file available</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
                    No approved forms are currently available.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
