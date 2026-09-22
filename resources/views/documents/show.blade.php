@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Registered Document</div>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $document->draf->title }}</h1>
            </div>
            <x-status-badge :status="$document->status?->value ?? 'active'" />
        </div>

        <dl class="grid gap-4 md:grid-cols-2 text-sm text-slate-600">
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Reference Code</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->draf->reference_code ?? 'N/A' }}</dd></div>
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Document Type</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->draf->documentType?->name ?? 'N/A' }}</dd></div>
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Applicability</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->draf->applicability?->label() ?? 'N/A' }}</dd></div>
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Originating Office</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->originatingOffice?->office ?? 'N/A' }}</dd></div>
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Status</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->status?->label() ?? $document->status }}</dd></div>
            <div class="rounded-xl border border-slate-200 p-4"><dt class="text-slate-500">Effectivity Date</dt><dd class="mt-2 font-medium text-slate-900">{{ $document->draf->effectivity_date?->format('M d, Y') ?? 'N/A' }}</dd></div>
        </dl>

        @if ($document->downloadable_doc_path)
            <div class="mt-6">
                <a href="{{ Storage::url($document->downloadable_doc_path) }}" target="_blank" class="inline-flex rounded-md bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white">Download File</a>
            </div>
        @endif
    </div>
@endsection
