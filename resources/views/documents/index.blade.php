@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Documents</h1>
            <p class="mt-2 text-sm text-slate-600">Approved and registered forms and templates.</p>
        </div>

        <div class="space-y-4">
            @forelse ($documents as $document)
                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-semibold text-slate-900">{{ $document->draf->title }}</div>
                            <div class="text-sm text-slate-600">{{ $document->draf->reference_code }} · {{ $document->draf->documentType?->name }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ $document->status->label() }}</span>
                            <a href="{{ route('documents.show', $document) }}" class="font-semibold text-[#0f3d68]">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center text-slate-500">No documents found.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
